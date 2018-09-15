//--------------------------------------- 模态框 ----------------------------------------
/**
 * 提示信息模态框
 * showMessageModal("animated bounceInRight", "sm", "warning", "删除成功");
 * @param effect
 * @param size [lg/sm]
 * @param level [danger/success/warning/info]
 * @param message
 */
function showMessageModal(effect, size, level, message, timeout) {
    var title = '';
    $("#showMessageModal").find(".modal-content").addClass(effect);
    $("#showMessageModal").find(".modal-dialog").addClass("modal-" + size);
    if ("warning" == level) {
        title = '<i class="text-warning fa fa-exclamation-triangle"></i> ';
    } else if ("error" == level) {
        title = '<i class="text-danger fa fa-times"></i> ';
    } else if ("success" == level) {
        title = '<i class="text-info fa fa-check"></i> ';
    } else {
        title = '<i class="text-success fa fa-info-circle"></i> ';
    }
    title += message;
    $("#showMessageModal").find(".modal-title").html(title);
    $("#showMessageModal").modal("show");
    setTimeout(function () {
        $("#showMessageModal").modal("hide");
    }, timeout);
}

/**
 * 确认信息模态框
 * confirmModal("animated bounceInRight", "sm", "submit", "你确定要删除吗？")
 * @param effect
 * @param size [lg/sm]
 * @param action [submit/delete/question]
 * @param message
 * @param type
 * @param url
 * @param data
 * @param async
 */
function confirmModal(effect, size, action, message) {
    var title = '';
    $("#confirmModal").find(".modal-content").addClass(effect);
    $("#confirmModal").find(".modal-dialog").addClass("modal-" + size);
    if ("submit" == action) {
        title = '<i class="text-info fa fa-check-square-o"></i> ';

    } else if ("delete" == action) {
        title = '<i class="text-danger initialism  fa fa-trash"></i> ';
    } else {
        title = '<i class="text-warning fa fa-exclamation-triangle"></i> ';
    }
    title += message;
    $("#confirmModal").find(".modal-title").html(title);
    $("#confirmModal").modal("show");
}

/**
 * 输入模态框
 * inputModal("animated bounceInRight", "", "添加菜单", "<input>");
 * @param effect
 * @param size [lg/sm]
 * @param title
 * @param content
 */
function inputModal(effect, size, title, content) {
    $("#inputModal").find(".modal-content").addClass(effect);
    $("#confirmModal").find(".modal-dialog").addClass("modal-" + size);
    $("#inputModal").find(".modal-title").html(title);
    $("#inputModal").find(".modal-body").html(content);
    $("#inputModal").modal("show");
}

//-------------------------------------- 模态框END --------------------------------------

//------------------------------------ sweet alert --------------------------------------
/**
 * 提示信息弹出框
 * showMessageAlert("error", "关闭成功！", "", "", 2000);
 * @param type [warning/error/success/info/input]
 * @param type
 * @param title
 * @param message
 * @param img
 * @param timeout
 */
function showMessageAlert(type, title, message, timeout) {
    swal({
        title: title, //标题
        text: message, //提示信息
        type: type, //弹出框类型 warning/error/success/info/input
        allowOutsideClick: true, //点击弹窗外关闭弹窗
        showConfirmButton: false, //确认按钮
        timer: timeout
    });
}

/**
 * 确认弹出框
 * @param type
 * @param title
 * @param message
 * @param callBack
 */
function confirmAlert(type, title, message, callBack) {
    swal({
        title: title, //标题
        text: message, //提示信息
        type: type, //弹出框类型 warning/error/success/info/input
        allowOutsideClick: true, //点击弹窗外关闭弹窗
        showConfirmButton: true, //确认按钮
        confirmButtonText: '确定', //按钮文本
        confirmButtonColor: "#1ab394", //按钮颜色十六进制
        closeOnConfirm: false,
        showCancelButton: true, //取消按钮
        cancelButtonText: '取消',//按钮文本
    }, callBack);
}

//---------------------------------- sweet alert END -------------------------------------

//------------------------------------ ajax and show -------------------------------------
/**
 * ajax请求
 * @param type
 * @param url
 * @param data
 * @param async
 * @param success
 * @param error
 */
function ajaxFromServer(type, url, data, async, success, error) {
    $.ajax({
        url: url,
        type: type,
        data: data,
        async: async,
        dataType: "json",
        success: success,
        error: error
    });
}

/**
 * 显示ajax请求的结果
 * @param type 1/2
 * @param confirmData[effect, size, action, message] / confirmData[type, title, message]
 * @param ajaxData[type, url, data, async]
 * @param refresh[type, timeout]
 */
function showAjaxMessage(type, confirmData, ajaxData, refresh) {
    if ("1" == type) {
        confirmModal(confirmData['effect'], confirmData['size'], confirmData['action'], confirmData['message']);
        $("#confirmModalButton").click(function () {
            $("#confirmModal").modal("hide");
            ajaxFromServer(ajaxData['type'], ajaxData['url'], ajaxData['data'], ajaxData['async'], function (data) {
                if ('200' == data['status']) {
                    showMessageModal("animated bounceInRight", "sm", "success", data['message'], refresh['timeout']);
                } else {
                    showMessageModal("animated bounceInRight", "sm", "danger", data['message'], refresh['timeout']);
                }
            }, function () {
                showMessageModal("animated bounceInRight", "sm", "warning", "系统异常！", refresh['timeout']);
            });
        });
    } else if ("2" == type) {
        confirmAlert(confirmData['type'], confirmData['title'], confirmData['message'], function () {
            ajaxFromServer(ajaxData['type'], ajaxData['url'], ajaxData['data'], ajaxData['async'], function (data) {
                if ('200' == data['status']) {
                    showMessageAlert("success", data['message'], "", refresh['timeout'])
                } else {
                    showMessageAlert("error", data['message'], "", refresh['timeout'])
                }
            }, function () {
                showMessageAlert("error", "系统异常！", "", refresh['timeout'])
            });
        });
    }
    if ("1" == refresh['type']) {
        setTimeout(function () {
            location.reload();
        }, refresh['timeout']);
    }
}

//----------------------------------- ajax and show END -----------------------------------
//------------------------------------- ajax and show -------------------------------------
function validation() {

}