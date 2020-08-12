@extends('layouts.admin') @section('content')
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin')}}">Home</a>
        </li>
        <li class="breadcrumb-item active">Torneios</li>
    </ol>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <h4 class="card-title mb-0">Torneios</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <ul id="TorneiosTab" role="tablist" class="nav nav-tabs">
                                    <li class="nav-item"><a id="torneios-tab" data-toggle="tab" role="tab" aria-selected="false" class="nav-link active show">Torneios</a></li>
                                    <li class="nav-item"><a id="torneios_team-tab" data-toggle="tab" role="tab" aria-selected="true" class="nav-link">Torneios team</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" aria-labelledby="torneios-tab" class="tab-pane fade active show">
                                        <div id="torneios_content" class="row">
                                            
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-8 mt-1" id="torneios_content_Pagination">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <p class="text-muted"> </p>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <ul class="pagination justify-content-center mb-2 mb-sm-0">
                                                        
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-auto ml-auto">
                                                <button class="btn btn-primary" id="btn_create_torneios" data-toggle="modal" data-target="#torneiosModal">
                                                    <i class="material-icons md-16">add_circle</i> Create
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div id="torneiosModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div>
                                            <h4 class="modal-title">Create torneios</h4>
                                        </div>
                                        <div>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" id="btn_create_ok" class="btn btn-primary" data-dismiss="modal">Ok</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        var type = '';
        var torneiosListData = {};
        $('#torneios-tab').click(function() {
            type = '';
            loadTorneiosList();
        })
        $('#torneios_team-tab').click(function() {
            type = 'team';
            loadTorneiosList();
        })
        $(`#input_search_chatlist`).click(function() {

        });

        loadTorneiosList();

        function loadTorneiosList(options = {}) {
            $.ajax({
                url: `{{ route('torneios.getTorneiosList') }}?type=` + type,
                type: "GET",
                dataType: 'json',
                data: options,
                success: function(res) {
                    torneiosListData = res;
                    refreshTorneiosList('torneios_content', torneiosListData)
                }
            })
        }

        function refreshTorneiosList(elementId, torneiosListData) {
            $(`#${elementId}`).html('');
            refreshPagination(elementId + "_Pagination", torneiosListData);
            var torneiosList = torneiosListData.data;
            torneiosList.forEach(project => {
                addTorneiosElement($(`#${elementId}`), project);
            });
        }

        function refreshPagination(pagiantion_id, torneiosListData) {
            var container = $(`#${pagiantion_id}`);
            var page_num = torneiosListData.page_num;
            var max_page = torneiosListData.max_page;
            var start = (torneiosListData.page_num - 1) * torneiosListData.page_size + 1;
            if (start < 0) start = 0;
            var end = torneiosListData.page_num * torneiosListData.page_size;
            if (end > torneiosListData.total_count) end = torneiosListData.total_count;
            container.find('.text-muted').html(` Showing ${start} to ${end} of ${numberWithCommas(torneiosListData.total_count)} entries `);
            var pageContainer = container.find('.pagination');
            pageContainer.html('');

            var left_item = $(`<li class="page-item ${page_num > 1 ? '': 'disabled'}">
                                    <a class="page-link" href="javascript:;" >
                                        <i class="material-icons">chevron_left</i>
                                    </a>
                                </li>`)
            left_item.click(function(e) {
                if ($(this).hasClass('disabled')) return;
                loadTorneiosList({
                    page_num: page_num - 1
                });
            })

            function createPageTag(page_index) {
                var item = $(`<li class="page-item">
                                    <a class="page-link" href="javascript:;">${page_index}</a>
                                </li>`);
                if (page_index == page_num) {
                    item.addClass('active');
                } else {
                    item.click(function() {
                        loadTorneiosList({
                            page_num: page_index
                        });
                    })
                }
                return item;
            }

            function addDotTag() {
                var item = $(`<li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">...</a>
                                </li>`);
                return item;
            }
            pageContainer.append(left_item);
            if (page_num <= 3) {
                for (let index = 1; index <= 3; index++) {
                    if (index > max_page) break;
                    var item = createPageTag(index);
                    pageContainer.append(item);
                }
                if (max_page > 3) {
                    if (max_page > 5) {
                        pageContainer.append(createPageTag(4));
                        pageContainer.append(addDotTag());
                        pageContainer.append(createPageTag(max_page));
                    } else {
                        pageContainer.append(createPageTag(4));
                        if (max_page == 5) pageContainer.append(createPageTag(5));
                    }
                }
            } else {
                pageContainer.append(createPageTag(1));
                pageContainer.append(addDotTag());
                pageContainer.append(createPageTag(page_num - 1));
                pageContainer.append(createPageTag(page_num));
                if (page_num < max_page) {
                    pageContainer.append(createPageTag(page_num + 1));
                    if (max_page > page_num + 2) {
                        pageContainer.append(addDotTag());
                    }
                    pageContainer.append(createPageTag(max_page));
                }
            }
            var right_item = $(`<li class="page-item ${page_num < max_page ? '': 'disabled'}">
                                    <a class="page-link" href="javascript:;" >
                                        <i class="material-icons">chevron_right</i>
                                    </a>
                                </li>`)
            right_item.click(function(e) {
                if ($(this).hasClass('disabled')) return;
                loadTorneiosList({
                    page_num: page_num + 1
                });
            })
            pageContainer.append(right_item);
        }

        // function numberWithCommas(x) {
        //     return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        // }

        function addTorneiosElement(element_id, torneios) {
            if (!torneios.left_time) {
                torneios.left_time = "unset";
            }
            var torneios_data = `<div class="col-lg-4">
                                    <div class="card text-white bg-primary">
                                        <div class="card-body pb-3 _torneios" onclick="fn_goto_torneios_content(${torneios.id})">
                                            <button type="button" class="btn_setting btn btn-transparent p-0 float-right">
                                                <i class="material-icons md-16">delete</i>
                                            </button>
                                            <button type="button" class="btn_setting btn btn-transparent p-0 float-right">
                                                <i class="material-icons md-16">settings</i>
                                            </button>

                                            <div class="text-value"><i class="material-icons">local_play</i></div>
                                            <div class="flex-txt-content">
                                                <div id="torneios_id" style="display:none">${torneios.id}</div>
                                                <div>${torneios.name}</div>
                                                <div>${torneios.no}</div>
                                                <div>${torneios.time_left}</div>
                                                <div>${torneios.user_count}/8</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
            element_id.append(torneios_data);
        }

        $("#btn_create_torneios").on("click", function() {
            var modal = $("#torneiosModal");
            var header_title = "Create torneios "+type;
            var content = `<div class="col-md-6">
                                <div class="form-group">
                                    <label for="Name">Name</label>
                                    <input id="Name" type="text" required="required" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="time_left">Time left</label>
                                    <input id="time_left" type="date" required="required" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no">Turn</label>
                                    <input id="no" type="text" required="required" class="form-control">
                                </div>
                            </div>`;
            fn_show_modal(modal, header_title, content);
        })

        $("#btn_setting").on("click", function() {
            var modal = $("#torneiosModal");
            var header_title = "Setting torneios";
            var content = `<div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Name">Name</label>
                                                <input id="Name" type="text" required="required" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="time_left">Time left</label>
                                                <input id="time_left" type="date" required="required" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="no">Turn</label>
                                                <input id="No" type="text" required="required" class="form-control">
                                            </div>
                                        </div>`;
        })

        $("#btn_create_ok").on("click", function () {
            var modal = $("#torneiosModal");
            var torneios_info = {};
            var name = modal.find("#Name").val();
            var no = modal.find("#no").val();
            var time_left = modal.find("#time_left").val();
            var is_team = 0;
            if (type=="team") {
                is_team = 1;
            }
            torneios_info = {
                "name": name,
                "no": no,
                "time_left": time_left,
                "is_team": is_team
            }
            $.ajax({
                url: `{{ route('torneios.create') }}`,
                type: "POST",
                data: {"torneios_info" : torneios_info},
                dataType: 'json',
                success: function(result) {
                    console.log("result id : ", result.id);
                    socket.emit('created_torneios', { "id": result.id });
                    loadTorneiosList();
                },
                error : function (error) {
                    console.log("error");
                }
            })
            
        })

        function fn_show_modal(modal, header_title, content) {
            modal.modal('show');
            modal.find('.modal-title').html('');
            modal.find('.modal-body .row').html('');
            modal.find('.modal-title').html(header_title);
            modal.find('.modal-body .row').html(content);
        }

    })
    function fn_goto_torneios_content(torneios_id) {
        location.href = `{{ route('torneios_content') }}id=` + torneios_id;
    }
</script>

@endsection