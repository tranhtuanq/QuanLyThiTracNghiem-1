// Cắt tham số url
let url = location.href.split("/");
let made = url[url.length - 1];
// Thông tin đề thi
let infoTest
// Khởi tạo mảng câu hỏi của đề thi
let arrQuestion = [];
// Khởi tạo mảng danh sách câu hỏi lấy từ db
let questions = [];

function getInfoTest() {
    return $.ajax({
        type: "post",
        url: "./test/getDetail",
        data: {
            made: made
        },
        dataType: "json",
        success: function (data) {
            infoTest = data;
        }
    });
}

function getQuestionOfTest() {
    return $.ajax({
        type: "post",
        url: "./test/getQuestion",
        data: {made: made},
        dataType: "json",
        success: function (response) {
            arrQuestion = response;
        }
    });
}

// Đợi khi ajax getInfoTest() thực hiện hoàn tất
$.when(getInfoTest(),getQuestionOfTest()).done(function(){
    console.log(arrQuestion)

    $("#name-test").text(infoTest.tende)
    $("#test-time").text(infoTest.thoigianthi);
    let slgioihan = [0,infoTest.socaude,infoTest.socautb,infoTest.socaukho]
    let arr_slch = countQuantityLevel(arrQuestion);

    loadDataListQuestion();
    showListQuesOfTest(arrQuestion);
    displayQuantityQueston()

    function countQuantityLevel(arrQuestion) {
        let result = [0,0,0,0];
        arrQuestion.forEach(question => {
            result[`${question.dokho}`]++
        });
        return result;
    }

    function displayQuantityQueston() {
        $("#slcaude").text(arr_slch[1]);
        $("#ttcaude").text(infoTest.socaude);
        $("#slcautb").text(arr_slch[2]);
        $("#ttcautb").text(infoTest.socautb);
        $("#slcaukho").text(arr_slch[3]);
        $("#ttcaukho").text(infoTest.socaukho);
    }
    

    function loadDataListQuestion() {
        $.ajax({
            type: "post",
            url: "./question/getQuestionBySubject",
            data: {
                mamonhoc: infoTest.monthi,
                machuong: 0,
                dokho: 0,
                content: ''
            },
            dataType: "json",
            success: function (response) {
                showListQuestion(response,arrQuestion);
                questions = response;
            }
        });
    }

    // Hiển thị danh sách câu hỏi của môn học ở cột bên trái
    function showListQuestion(questions,arrQuestion) {
        let html = ``;
        questions.forEach((question,index) => {
            let dokhotext = ["", "Dễ","TB","Khó"];
            let check = arrQuestion.findIndex(item => item.macauhoi == question.macauhoi) != -1 ? "checked" : "";
            html += `<li class="list-group-item d-flex">
                <div class="form-check">
                    <input class="form-check-input item-question" type="checkbox" id="q-${question.macauhoi}" data-id="${question.macauhoi}" data-index="${index}" ${check}>
                    <label class="form-check-label text-muted" for="q-${question.macauhoi}" style="word-break: break-all;">${question.noidung}</label>
                </div>
                <span class="badge rounded-pill bg-dark m-1 float-end h-100">${dokhotext[question.dokho]}</span>
                
            </li>`
        });
        $("#list-question").html(html);
    }

    // Xử lý sự kiện change trên ô input câu hỏi
    $(document).on("click", ".item-question",function () {
        let index = $(this).data("index");
        let macauhoi = $(this).data("id");

        if($(this).prop("checked") == true) {
            if(arr_slch[`${questions[index].dokho}`] < slgioihan[`${questions[index].dokho}`]) {
                let answer = getAnswer(questions[index].macauhoi);
                questions[index].cautraloi = answer;
                arrQuestion.push(questions[index]);
                arr_slch[`${questions[index].dokho}`]++;
                displayQuantityQueston();
                showListQuesOfTest(arrQuestion);
            } else {
                $(this).prop("checked",false);
                Dashmix.helpers('jq-notify', { type: 'danger', icon: 'fa fa-times me-1', message: 'Số lượng câu hỏi ở mức độ đã đủ!' });
            }
        } else {
            let i = arrQuestion.findIndex(item => item.macauhoi == macauhoi);
            arrQuestion.splice(i,1);
            arr_slch[`${questions[index].dokho}`]--;
            displayQuantityQueston();
            showListQuesOfTest(arrQuestion);
        }
    });

    // Hiển thị preview bên phải
    function showListQuesOfTest(questions) {
        let html = ``;
        if(questions.length == 0) {
            html += `<p class="text-center">Chưa có câu hỏi</p>`
        } else {
            questions.forEach((question,index) => {
                html += `<div class="question mb-3 d-flex justify-content-between">
                    <div class="question-top px-3">
                        <p class="question-content fw-bold mb-3">${index + 1}. ${question.noidung}</p>
                        <div class="row">`;
                    question.cautraloi.forEach((item,i) => {
                    html += `<div class="col-12 mb-1">
                        <p class="mb-1"><b>${String.fromCharCode(i + 65)}.</b> ${item.noidungtl}</p>
                    </div>`;
                });
                html += `</div></div>
                <div class="btn-group-vertical h-100" role="group">
                    <button type="button" class="btn btn-info btn-up" data-bs-toggle="tooltip" data-bs-placement="left" title="Đưa lên trên" data-index="${index}"><i class="fa fa-arrow-up"></i></button>
                    <button type="button" class="btn btn-info btn-down" data-bs-toggle="tooltip" data-bs-placement="left" title="Đưa xuống dưới" data-index="${index}"><i class="fa fa-arrow-down"></i></button>
                    <button type="button" class="btn btn-info btn-delete" data-bs-toggle="tooltip" data-bs-placement="left" title="Xoá câu hỏi" data-index="${index}"><i class="fa fa-delete-left"></i></button>
                </div>
                </div>`
            });   
        }
        $("#list-question-of-test").html(html);
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    function getAnswer(macauhoi) {
        let ans = [];
        $.ajax({
            type: "post",
            url: "./question/getAnswerById",
            data: {
                id: macauhoi
            },
            async: false,
            dataType: "json",
            success: function (response) {
                ans = response;
            }
        });
        return ans;
    }

    $(document).on("click", ".btn-up",function () {
        let index = $(this).data("index");
        let a = arrQuestion[index];
        arrQuestion[index] = arrQuestion[index - 1];
        arrQuestion[index - 1] = a;
        $(this).tooltip('hide');
        showListQuesOfTest(arrQuestion);
    });

    $(document).on("click", ".btn-down",function () {
        let index = $(this).data("index");
        let a = arrQuestion[index];
        arrQuestion[index] = arrQuestion[index + 1];
        arrQuestion[index + 1] = a;
        $(this).tooltip('hide');
        showListQuesOfTest(arrQuestion);
    });

    $(document).on("click", ".btn-delete",function () {
        let index = $(this).data("index");
        arr_slch[`${arrQuestion[index].dokho}`]--
        $(`#q-${arrQuestion[index].macauhoi}`).prop("checked",false);
        $(this).tooltip('hide');
        arrQuestion.splice(index,1);
        showListQuesOfTest(arrQuestion);
        displayQuantityQueston()
    });

    $("#save-test").click(function (e) { 
        e.preventDefault();
        if(arr_slch[1] == slgioihan[1] && arr_slch[2] == slgioihan[2] && arr_slch[3] == slgioihan[3]) {
            console.log(arrQuestion)
            $.ajax({
                type: "post",
                url: "./test/addDetail",
                data: {
                    made: infoTest.made,
                    cauhoi: arrQuestion
                },
                success: function (response) {
                    if(response) {
                        Dashmix.helpers('jq-notify', { type: 'success', icon: 'fa fa-check me-1', message: 'Thêm câu hỏi thành công!' });
                    } else {
                        Dashmix.helpers('jq-notify', { type: 'danger', icon: 'fa fa-times me-1', message: 'Tạo đề không thành công!' });
                    }
                }
            });
        } else {
            Dashmix.helpers('jq-notify', { type: 'danger', icon: 'fa fa-times me-1', message: 'Số lượng câu hỏi không phù hợp!' });
        }
    });
});