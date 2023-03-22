<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Tất cả câu hỏi</h3>
            <div class="block-options">
                <button type="button" class="btn btn-hero btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-question" id="addquestionnew"><i class="fa-regular fa-plus"></i> Thêm câu hỏi mới</button>
            </div>
        </div>
        <div class="block-content">
            <form onsubmit="return false;">
                <div class="row mb-4 align-items-center">
                    <div class="col-9">
                    <div class="input-group">
                            <button class="btn btn btn-alt-primary dropdown-toggle btn-filter" type="button" data-bs-toggle="dropdown" aria-expanded="false">Tất cả</button>
                            <ul class="dropdown-menu mt-1">
                                <li><a class="dropdown-item filter-search" href="javascript:void(0)" data-value="0">Tất cả</a></li>
                                <li><a class="dropdown-item filter-search" href="javascript:void(0)" data-value="1">Môn học</a></li>
                                <li><a class="dropdown-item filter-search" href="javascript:void(0)" data-value="2">Câu hỏi</a></li>
                            </ul>
                            <input type="text" class="form-control" placeholder="Tìm kiếm nhóm..." id="one-ecom-orders-search">
                        </div>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-borderless table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">ID</th>
                            <th>Nội dung câu hỏi</th>
                            <th class="d-none d-sm-table-cell">Môn học</th>
                            <th class="d-none d-xl-table-cell">Độ khó</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="listQuestion">

                    </tbody>
                </table>
            </div>
            <nav aria-label="Photos Search Navigation">
                <ul class="pagination pagination-sm justify-content-center mt-2" id="pagination">
                    <li class="page-item active">
                        <a class="page-link" href="javascript:void(0)">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)">4</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-question" tabindex="-1" role="dialog" aria-labelledby="modal-add-question" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <ul class="nav nav-tabs nav-tabs-alt mb-1" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="btabs-alt-static-home-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-home" role="tab" aria-controls="btabs-alt-static-home" aria-selected="true">
                        Thêm thủ công
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="btabs-alt-static-profile-tab" data-bs-toggle="tab" data-bs-target="#btabs-alt-static-profile" role="tab" aria-controls="btabs-alt-static-profile" aria-selected="false">
                        Thêm từ file
                    </button>
                </li>
                <li class="nav-item ms-auto">
                    <button type="button" class="btn btn-close p-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </li>
            </ul>
            <div class="modal-body block block-transparent bg-white mb-0 block-rounded">
                <div class="block-content tab-content">
                    <div class="tab-pane active" id="btabs-alt-static-home" role="tabpanel" aria-labelledby="btabs-static-home-tab" tabindex="0">
                        <form method="POST" onsubmit="return false;">
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="" class="form-label">Môn học</label>
                                        <select class="js-select2 form-select data-monhoc" data-tab="1" id="mon-hoc" name="mon-hoc" style="width: 100%;" data-placeholder="Choose one.." required>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">Chương</label>
                                        <select class="js-select2 form-select data-chuong" id="chuong" data-tab="1" style="width: 100%;" data-placeholder="Choose one.." required>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">Độ khó</label>
                                        <select class="js-select2 form-select" id="dokho" style="width: 100%;" data-placeholder="Choose one.." required>
                                            <option></option>
                                            <option value="1">Cơ bản</option>
                                            <option value="2">Trung bình</option>
                                            <option value="3">Nâng cao</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="js-ckeditor">Nội dung câu hỏi</label>
                                <textarea id="js-ckeditor" name="ckeditor" required></textarea>
                            </div>
                            <div class="mb-4 row">
                                <h6>Danh sách đáp án</h6>
                                <div class="table-responsive">
                                    <table class="table table-vcenter">
                                        <tbody id="list-options">
                                        </tbody>
                                    </table>
                                </div>
                                <p>
                                    <button class="btn btn-hero btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#add_option" aria-expanded="false" aria-controls="add_option">
                                        Thêm câu trả lời <i class="fa fa-fw fa-angle-down opacity-50"></i>
                                    </button>
                                </p>
                                <div class="collapse" id="add_option">
                                    <div class="card card-body">
                                        <label class="form-label" for="option-content">Nội dung trả lời</label>
                                        <textarea id="option-content" name="ckeditor"></textarea>
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" value="" id="true-option">
                                            <label class="form-check-label" for="true-option">
                                                Đáp án đúng
                                            </label>
                                        </div>
                                        <p>
                                            <button type="button" class="btn btn-primary mt-3" id="save-option">Lưu câu
                                                trả lời</button>
                                            <button type="button" class="btn btn-primary mt-3" id="update-option">Cập
                                                nhật câu trả lời</button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-alt-primary" id="add_question"><i class="fa fa-fw fa-plus me-1"></i> Lưu câu hỏi</button>
                                <button class="btn btn-alt-primary" id="edit_question"><i class="fa fa-fw fa-plus me-1"></i> Sửa câu hỏi</button>
                                <input type="hidden" value="" id="question_id">
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="btabs-alt-static-profile" role="tabpanel" aria-labelledby="btabs-static-profile-tab" tabindex="0">
                        <form id="form-upload" method="POST" enctype="multipart/form-data">
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="" class="form-label">Môn học</label>
                                        <select id="monhocfile" class="js-select2 form-select data-monhoc" data-tab="2" style="width: 100%;" data-placeholder="Choose one.." required>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Chương</label>
                                        <select id="chuongfile" class="js-select2 form-select data-chuong" data-tab="2" style="width: 100%;" data-placeholder="Choose one.." required>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="js-ckeditor">Nội dung</label>
                                <input class="form-control" type="file" id="file-cau-hoi" accept=".docx" required>
                            </div>
                            <div class="mb-4">
                                <em>Vui lòng soạn câu hỏi theo đúng định dạng. <a href="">Tải về file mẫu Docx</a></em>
                            </div>
                            <div class="mb-4 d-flex">
                                <button type="submit" class="btn btn-hero btn-primary" id="nhap-file"><i class="fa fa-cloud-arrow-up"></i> Thêm vào hệ thống</button>
                            </div>
                        </form>
                        <div id="content-file"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>