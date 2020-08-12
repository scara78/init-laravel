<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Workerman\Worker;
use PHPSocketIO\SocketIO;
use App\Models\Chat;
use App\Models\ProTaskTranslator;
use App\Models\User;


class ChatServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ChatServer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chat Server';

    protected $server = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private $clients = [];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->server = new SocketIO(2222);
        $this->server->on('connection', function ($socket) {
            $this->clients[$socket->id] = $socket;

            echo "client: " . $socket->id . " connected" . PHP_EOL;

            try {
                $this->handleSocket($socket);

                $this->setupAuth($socket);

                $this->setupChat($socket);
            } catch (\Throwable $exception) {
                print_r($exception);
            }
        });

        Worker::runAll();
    }

    // ============ auth section =============
    private function setupAuth($socket)
    {
        $this->clearAuth($socket);

        $socket->on('login', function ($data) use ($socket) {
            $this->login($socket, $data["socket_token"]);
        });
    }

    private function login($socket, $token)
    {
        $user = User::currentSocketUser($token);
        if (!empty($user)) {
            $socket->user_id = $user->id;
            $direction = false;
            if ($user->checkRole('admin')) {
                $socket->role = 'Admin';
                $direction = true;
            } else if ($user->checkRole('translator')) {
                $socket->role = 'Translator';
            } else if ($user->checkRole('user')) {
                $socket->role = 'User';
            }
            $this->setOnlineState($socket, true);
            $socket->emit('login', $direction);
        } else {
            $this->clearAuth($socket);
        }
    }

    private function setOnlineState($socket, $online_state) {
        if(!empty($socket->user_id)) {
            $sockets_of_user = $this->getSocketsFromUserId($socket->user_id);
            if(count($sockets_of_user) == 0 && $online_state == false) {
                $user = User::find($socket->user_id);
                $user->setOnlineState(false);
                $socket->broadcast->emit('online_state', array(
                    "user_id" => $user->id,
                    "online_state" => false
                ));
            } else if(count($sockets_of_user) == 1 && $online_state == true) {
                $user = User::find($socket->user_id);
                $user->setOnlineState(true);
                $socket->broadcast->emit('online_state', array(
                    "user_id" => $user->id,
                    "online_state" => true
                ));
            }
        }
    }

    private function clearAuth($socket)
    {
        $socket->role = "";
        $socket->user_id = "";
    }

    private function checkRole($socket, $role)
    {
        return $socket->role == $role;
    }


    // ============ chat section =============
    private function setupChat($socket)
    {
        $socket->on('chat', function ($data) use ($socket) {
            $this->receiveChat($socket, $data);
        });

        $socket->on('read', function ($data) use ($socket) {
            $this->readChat($socket, $data);
        });
    }

    private function receiveChat($socket, $data)
    {
        $project_id = $data["project_id"];
        $message = $data["message"];
        $project = ProTaskTranslator::find($project_id);
        $translator_id = $project->translator_id;
        if ($this->checkRole($socket, 'Admin')) {
            $chat = Chat::sendToTranslatorFromAdmin($project_id, $message);
        } else {
            if($translator_id != $socket->user_id) return;
            $chat = Chat::sendToAdminFromTranslator($project_id, $message);
        }
        $this->emitToProject($project, 'chat', $chat);
    }

    private function readChat($socket, $data)
    {
        $project_id = $data["project_id"];
        $chat_id = $data["chat_id"];
        $project = ProTaskTranslator::find($project_id);
        $translator_id = $project->translator_id;
        if($this->checkRole($socket, 'Admin')) {
            Chat::setAdminReadState($project_id, $chat_id);
        } else {
            if($translator_id != $socket->user_id) return;
            Chat::setTranslatorReadState($project_id, $chat_id);
        }
        $this->emitToProject($project, 'read', $data);
    }


    // ============ handle socket section =============
    private function handleSocket($socket)
    {
        $socket->on('error', function ($error) {
            $this->errorHandler($error);
        });

        $socket->on('disconnect', function () use ($socket) {
            $this->disconnectHandler($socket);
        });
    }

    public function errorHandler($error)
    {
        echo "connection error: " . $error . PHP_EOL;
    }

    public function disconnectHandler($socket)
    {
        echo "connection " . $socket->id . " was disconnected" . PHP_EOL;
        unset($this->clients[$socket->id]);
        $this->setOnlineState($socket, false);
    }

    public function emitToProject($project, $event, $data) {
        // emit the chat message to translator
        $this->emitToUser($project->translator_id, $event, $data);
        // emit the chat message to admin
        $this->emitToAdmin($event, $data);
    }

    private function emitToUser($user_id, $event, $data)
    {
        $sockets = $this->getSocketsFromUserId($user_id);
        $this->emitToSockets($sockets, $event, $data);
    }

    private function emitToAdmin($event, $data)
    {
        $sockets = $this->getSocketsFromUserRole('Admin');
        $this->emitToSockets($sockets, $event, $data);
    }
    public function emitToSockets($sockets, $event, $data)
    {
        foreach ($sockets as $socket_id => $socket) {
            $socket->emit($event, $data);
        }
    }

    public function getSocketsFromUserId($user_id)
    {
        return array_filter($this->clients, function ($socket, $socket_id) use ($user_id) {
            return $socket->user_id == $user_id;
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function getSocketsFromUserRole($role)
    {
        return array_filter($this->clients, function ($socket, $socket_id) use ($role) {
            return $socket->role == $role;
        }, ARRAY_FILTER_USE_BOTH);
    }

}
