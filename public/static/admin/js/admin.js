$(document).ready(function () {

    //size   :  lg  sm
    //level  danger  warning info
    showMessageModal("animated bounceInRight", "sm", "info", "确定要删除吗？");
    /**
     * 信息提示模态框显示
     * @param effect
     * @param size
     * @param level
     * @param message
     */
    function showMessageModal(effect, size, level, message) {
        var title = '';
        $("#showMessageModal").modal("show");
        $("#showMessageModal").find(".modal-content").addClass(effect);
        $("#showMessageModal").find(".modal-dialog").addClass("modal-" + size);
        if ("warning" == level) {
            title = '<i class="text-warning fa fa-exclamation-triangle"></i> ';
        } else if ("danger" == level) {
            title = '<i class="text-danger fa fa-times-circle"></i> ';
        } else if ("info" == level) {
            title = '<i class="text-info fa fa-info-circle"></i> ';
        }
        title += message;
        $("#showMessageModal").find(".modal-title").html(title);
    }

    function showMessageModal2(effect, size, level, message) {

    }
});