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

/**
 * 求人情報の別ファイル名を生成して、隠しinputに保存する
 * @param {*} inputpath
 * @param {*} newFileName
 * @param {*} virtualfilename
 * @returns
 */
function generateCustomName(inputpath, newFileName, virtualfilename) {
    const fileInput = document.getElementById(inputpath);
    const hiddenInput = document.getElementById(newFileName);

    // ファイルが選択されていなければ処理を抜ける
    if (fileInput.files.length === 0) {
        hiddenInput.value = "";
        return;
    }

    const originalFile = fileInput.files[0];
    const originalName = originalFile.name;
    // 本のファイルを分割して、拡張子を取得
    let parts = originalName.split(".");
    let ext = parts.length > 1 ? "." + parts.pop().toLowerCase() : "";
    let name = parts
        .join(".")
        .toLowerCase()
        .replace(/[^a-z0-9]/g, "");
    // 別名を作る
    const today = new Date().toISOString().slice(0, 10).replace(/-/g, ""); // "20260608"
    const aliasName = virtualfilename + ext;

    // 3. 隠しテキストボックスに別名を保存する
    hiddenInput.value = aliasName;

    console.log("隠しテキストボックスに保存された別名:", hiddenInput.value);
}
