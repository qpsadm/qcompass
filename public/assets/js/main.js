const NEW = 1; //新規登録
const EDI = 2; //編集
const DEL = 3; //削除

function comfirm_alert(flag, id, url) {
    if (flag == DEL) {
        // 削除
        let result = window.confirm("該当データを削除します。よろしいですか。");
        if (result) {
            // Deleteプログラムに遷移
            location.href = url + "?id=" + id;
        } else {
            return false;
        }
    } else if (flag == EDI) {
        // 編集
        let result = window.confirm("編集データを登録します。よろしいですか。");
        if (result) {
            // Updateプログラムに遷移
            return true;
        } else {
            return false;
        }
    } else if (flag == NEW) {
        // 新規
        let result = window.confirm("入力データを登録します。よろしいですか。");
        if (result) {
            return true;
        } else {
            return false;
        }
    }
}
