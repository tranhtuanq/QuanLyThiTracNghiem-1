$(document).ready(function () {
    let groups = [];
    $('.btn-join-group').on("click", function () {
        $.ajax({
            type: "post",
            url: "./client/joinGroup",
            data: {
                mamoi: $("#mamoi").val()
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                if(response == 0) {
                    Dashmix.helpers('jq-notify', { type: 'danger', icon: 'fa fa-times me-1', message: "Mã mời không hợp lệ !"});
                }else if(response == 1) {
                    Dashmix.helpers('jq-notify', { type: 'danger', icon: 'fa fa-times me-1', message: "Bạn đã tham gia nhóm này !"});
                } else {
                    $("#modal-join-group").modal("hide");
                    groups.push(response);
                    showListGroup(groups);
                    Dashmix.helpers('jq-notify', { type: 'success', icon: 'fa fa-check me-1', message: "Tham gia nhóm thành công !"});
                }
            }
        });
    });

    function loadDataGroups() {
        $.getJSON("./client/loadDataGroups",
            function (data) {
                groups = data;
                showListGroup(data)
            }
        );
    }

    loadDataGroups()

    function showListGroup(groups) {
        let html = ``;
        groups.forEach(group => {
            html += `<div class="col-md-6 col-xl-4">
                <div class="block block-rounded h-100 mb-0">
                    <div class="block-header">
                        <div class="flex-grow-1 text-muted fs-sm fw-semibold">
                            <i class="fa fa-user me-2"></i>${group.hoten}
                        </div>
                        <div class="block-options">
                            <div class="dropdown">
                                <button type="button" class="btn btn-alt-secondary dropdown-toggle module__dropdown"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-gears"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-users me-1"></i> People
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-bell me-1"></i> Alerts
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="fa fa-fw fa-check-double me-1"></i> Tasks
                                    </a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="be_pages_projects_edit.html">
                                        <i class="fa fa-fw fa-pencil-alt me-1"></i> Edit Project
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-content bg-body-light text-center">
                        <h3 class="fs-4 mb-3">
                            <a href="javascript:void(0)" class="link-fx">${group.mamonhoc} - ${group.tenmonhoc}</a>
                        </h3>
                        <h5 class="fs-6 text-muted mb-3">NH${group.namhoc} - HK${group.hocky}</h5>
                        <div class="push">
                            <span class="badge bg-info text-uppercase fw-bold py-2 px-3">${group.tennhom}</span>
                        </div>
                    </div>
                    <div class="block-content block-content-full">
                        <div class="row g-sm">
                            <div class="col-12">
                                <button class="btn w-100 btn-alt-secondary btn-view-group" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                                aria-controls="offcanvasExample" data-id="${group.manhom}">
                                    <i class="fa fa-eye me-1 opacity-50"></i> Xem nhóm
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`
        });
        $("#list-groups").html(html);
    }

    $(document).on('click', ".btn-view-group", function () {
        let manhom = $(this).data("id");
        loadDataTest(manhom);
        loadDataFriend(manhom);
    });

    function showListTest(tests) {
        let html = ``;
        if(tests.length != 0) {
            tests.forEach(test => {
                html += `<div class="block block-rounded block-fx-pop mb-2">
                    <div class="block-content block-content-full border-start border-3 border-primary">
                        <div class="d-md-flex justify-content-md-between align-items-md-center">
                            <div class="p-1 p-md-2">
                                <h3 class="h4 fw-bold mb-3">
                                    <a href="./test/start/${test.made}" class="text-dark link-fx">${test.tende}</a>
                                </h3>
                                <p class="fs-sm text-muted mb-0">
                                    <i class="fa fa-clock me-1"></i> Diễn ra từ <span>${test.thoigianbatdau}</span> đến <span>${test.thoigianketthuc}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
        } else {
            html += `<p class="text-center">Chưa có đề thi...</p>`
        }
        $(".list-test").html(html);
    }

    function loadDataTest(manhom) {
        $.ajax({
            type: "post",
            url: "./test/getTestGroup",
            data: {
                manhom: manhom
            },
            dataType: "json",
            success: function (response) {
                showListTest(response);
            }
        });
    }

    function loadDataFriend(manhom) {
        $.ajax({
            type: "post",
            url: "./client/getFriendList",
            data: {
                manhom: manhom
            },
            dataType: "json",
            success: function (response) {
                showListFriend(response);
            }
        });
    }

    function showListFriend(friends) {
        let html = ``;
        if(friends.length != 0) {
            friends.forEach(friend => {
                html += `<li>
                    <div class="d-flex py-2 align-items-center">
                        <div class="flex-shrink-0 mx-3 overlay-container">
                            <img class="img-avatar img-avatar48"
                                src="./public/media/avatars/avatar0.jpg" alt="">
                        </div>
                        <div class="fw-semibold">${friend.hoten}</div>
                    </div>
                </li>`
            });
        } else {
            html += `<p class="text-center">Không có dữ liệu</p>`
        }
        $(".list-friends").html(html);
    }
});