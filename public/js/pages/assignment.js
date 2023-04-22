Dashmix.helpersOnLoad(["jq-select2"]);

$(document).ready(function(){

    $(".js-select2").select2({
        dropdownParent: $("#modal-add-assignment"),
    });

    function loadAssignment(){
        $.get("./assignment/getAssignment",
            function (data) {
                let html = '';
                let index = 1;
                data.forEach(element => {
                    html += `<tr>
                    <td class="text-center fs-sm">
                        <a class="fw-semibold" href="#">
                            <strong>${index++}</strong>
                        </a>
                    </td>
                    <td>
                        ${element['hoten']}
                    </td>
                    <td class="text-center">
                        ${element['mamonhoc']}
                    </td>
                    <td>
                        <a class="fw-semibold">${element['tenmonhoc']}</a>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-alt-secondary btn-delete-assignment" data-bs-toggle="tooltip" aria-label="Delete" data-bs-original-title="Delete" data-id="${element['manguoidung']}">
                            <i class="fa fa-fw fa-times"></i>
                        </a>
                    </td>
                </tr>`
                });
                $("#listAssignment").html(html);
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            "json"
        );
    }

    loadAssignment();
    
    $.get("./assignment/getGiangVien",
        function (data) {
            let html = "<option></option>";
            data.forEach(element => {
                html += `<option value="${element['id']}">${element['hoten']}</option>`;
            });
            $("#giang-vien").html(html);
        },
        "json"
    );

    $("#add_assignment").click(function(){
        $("#giang-vien").val("").trigger("change");
        $.get("./assignment/getMonHoc",
        function (data) {
            console.log(data)
            let html = "";
            data.forEach(element => {
                html += `<tr>
                <td class="text-center">
                    <input class="form-check-input" type="checkbox" name="selectSubject" value="${element['mamonhoc']}">
                </td>
                <td class="text-center">${element['mamonhoc']}</td>
                <td>${element['tenmonhoc']}</td>
                <td class="text-center">${element['sotinchi']}</td>
                <td class="text-center">${element['sotietlythuyet']}</td>
                <td class="text-center">${element['sotietthuchanh']}</td>
            </tr>`
            });
            $("#list-subject").html(html);
        },
        "json"
    );
    })

    $("#btn_assignment").click(function(){
        let listAssignment = [];
        $("input:checkbox[name=selectSubject]:checked").each(function(){
            let subject = {
                mamonhoc: $(this).val()
            }
            listAssignment.push(subject);
        });
        let giangvien = $("#giang-vien").val();
        if(listAssignment.length === 0){
            delteAssignmentUser(giangvien)
            loadAssignment();
            $("#modal-add-assignment").modal("hide");
            Dashmix.helpers('jq-notify', {type: 'success', icon: 'fa fa-check me-1', message: 'Phân công thành công! :)'});
        } else {
            delteAssignmentUser(giangvien)
            addAssignment(giangvien,listAssignment);
        }
    })

    $(document).on("change", "#giang-vien", function (e) {
        let giangvien = $("#giang-vien").val();
        $.ajax({
            type: "post",
            url: "./assignment/getAssignmentByUser",
            data: {
                id: giangvien
            },
            dataType: "json",
            success: function (response) {
                $("input:checkbox[name=selectSubject]:checked").removeAttr('checked');
                let data = response;
                data.forEach(element => {
                    $(`input:checkbox[value=${element['mamonhoc']}]`).attr("checked", "checked");
                });
                
            }
        });
        
    })


    function addAssignment(giangvien,listSubject){
        
        $.ajax({
            type: "post",
            url: "./assignment/addAssignment",
            data: {
                magiangvien: giangvien,
                listSubject: listSubject
            },
            dataType: "json",
            success: function (response) {
                if(response){
                    $("#modal-add-assignment").modal("hide");
                    Dashmix.helpers('jq-notify', {type: 'success', icon: 'fa fa-check me-1', message: 'Phân công thành công! :)'});
                } else {
                    $("#modal-add-assignment").modal("hide");
                    setTimeout(function(){
                        Dashmix.helpers('jq-notify', {type: 'danger', icon: 'fa fa-times me-1', message: 'Phân công chưa thành công!'});
                    },10)
                }
                loadAssignment();
            }
        });
    }

    function delteAssignmentUser(giangvien){
        $.ajax({
            type: "post",
            url: "./assignment/deleteAll",
            data: {
                id: giangvien
            },
            success: function (response) {
            }
        });
    }

    $(document).on("click", ".btn-delete-assignment", function () {
        let id = $(this).data("id");
        let mamon = $(this).closest("td").closest("tr").children().eq(2).text();
        let e = Swal.mixin({
            buttonsStyling: !1,
            target: "#page-container",
            customClass: {
                confirmButton: "btn btn-success m-1",
                cancelButton: "btn btn-danger m-1",
                input: "form-control"
            }
        });
    
        e.fire({
            title: "Are you sure?",
            text: "Bạn có chắc chắn muốn xoá phân công?",
            icon: "warning",
            showCancelButton: !0,
            customClass: {
                confirmButton: "btn btn-danger m-1",
                cancelButton: "btn btn-secondary m-1"
            },
            confirmButtonText: "Vâng, tôi chắc chắn!",
            html: !1,
            preConfirm: e => new Promise((e => {
                setTimeout((() => {
                    e()
                }), 50)
            }))
        }).then((t => {
            if(t.value == true){
                $.ajax({
                    type: "post",
                    url: "./assignment/delete",
                    data: {
                        id: id,
                        mamon: mamon
                    },
                    success: function (response) {
                        if(response) {
                            e.fire("Deleted!", "Xóa phân công thành công!", "success")
                            loadAssignment();
                        } else {
                            e.fire("Lỗi !", "Xoá phân công thành công !)", "error")
                        }
                    }
                });
            }
        }))
      });

      
})

