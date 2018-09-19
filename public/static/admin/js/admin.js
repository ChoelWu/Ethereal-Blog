//--------------------------------------- 模态框 ----------------------------------------
/**
 * 提示信息模态框
 * showMessageModal("animated bounceInRight", "sm", "warning", "删除成功");
 * @param effect
 * @param size [lg/sm]
 * @param level [danger/success/warning/info]
 * @param message
 * @param timeout
 * @param afterHide
 */
function showMessageModal(effect, size, level, message, timeout, afterHide) {
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
    $('#showMessageModal').on('hidden.bs.modal', afterHide);
}

/**
 * 确认信息模态框
 * confirmModal("animated bounceInRight", "sm", "submit", "你确定要删除吗？")
 * @param effect
 * @param size [lg/sm]
 * @param action [submit/delete/question]
 * @param message
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
function inputModal(effect, size, title) {
    $("#inputModal").find(".modal-content").addClass(effect);
    $("#inputModal").find(".modal-dialog").addClass("modal-" + size);
    $("#inputModal").find(".modal-title").html(title);
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
 * @param url
 * @param data
 * @param success
 * @param error
 */
function ajaxFromServer(url, data, success, error) {
    $.ajax({
        url: url,
        type: "post",
        data: data,
        async: false,
        timeout: 15000,
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
            ajaxFromServer(ajaxData['url'], ajaxData['data'], function (data) {
                if ('1' == data['status']) {
                    showMessageModal("animated flipInX", "sm", "success", data['message'], refresh['timeout'], function () {
                        if ("1" == refresh["type"]) {
                            window.location.href = refresh['url'];
                        }
                    });
                } else if ('0' == data['status']) {
                    showMessageModal("animated flipInX", "sm", "error", data['message'], refresh['timeout'], function () {
                        if ("1" == refresh["type"]) {
                            window.location.href = refresh['url'];
                        }
                    });
                }
            }, function () {
                showMessageModal("animated flipInX", "sm", "warning", "系统异常！", refresh['timeout'], function () {
                    if ("1" == refresh["type"]) {
                        window.location.href = refresh['url'];
                    }
                });
            });
        });
    } else if ("2" == type) {
        confirmAlert(confirmData['type'], confirmData['title'], confirmData['message'], function () {
            ajaxFromServer(ajaxData['url'], ajaxData['data'], function (data) {
                if ('1' == data['status']) {
                    showMessageAlert("success", data['message'], "", refresh['timeout']);
                    if ("1" == refresh["type"]) {
                        refreshPage(refresh['timeout'], refresh['url']);
                    }
                } else if ('0' == data['status']) {
                    showMessageAlert("error", data['message'], "", refresh['timeout']);
                    if ("1" == refresh["type"]) {
                        refreshPage(refresh['timeout'], refresh['url']);
                    }
                }
            }, function () {
                showMessageAlert("error", "系统异常！", "", refresh['timeout']);
                if ("1" == refresh["type"]) {
                    refreshPage(refresh['timeout'], refresh['url']);
                }
            });
        });
    }
}

/**
 * 延时刷新
 * @param timeout
 */
function refreshPage(timeout, url) {
    setTimeout(function () {
        window.location.href = url;
    }, timeout);
}

//----------------------------------- ajax and show END -----------------------------------
//------------------------------------- ajax and show -------------------------------------
function validation() {

}


//--------------------------------------- Switchery --------------------------------------
/**
 * 开关按钮赋值
 * @param switchElement
 * @param checkedBool
 */
function setSwitchery(switchElement, checkedBool) {
    if ((checkedBool && !switchElement.isChecked()) || (!checkedBool && switchElement.isChecked())) {
        switchElement.setPosition(true);
        switchElement.handleOnchange(true);
    }
}

/**
 * 根据值控制开关按钮
 * @param status
 * @param switchery
 */
function setSwitch(status, switchery) {
    if (status == "1") {
        setSwitchery(switchery, true);
    } else {
        setSwitchery(switchery, false);
    }
}

/**
 * 根据开关状态设置输入框的值
 * @param elem
 * @param name
 */
function setSwitchInInput(elem, name) {
    if (elem.checked) {
        $("input[name=" + name + "]").val('1');
    } else {
        $("input[name=" + name + "]").val('0');
    }
}

//------------------------------------- Switchery END ------------------------------------