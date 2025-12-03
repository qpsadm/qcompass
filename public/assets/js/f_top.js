"use-strict"

// KVの動画読み込み切り替え

$(function () {
    const today = new Date();
    const month = today.getMonth() + 1;

    const videoPath = `${baseVideoPath}/kv_movie_${month}.mp4`;
    const posterPath = `${baseVideoPath}/kv_poster_${month}.jpeg`;

    const $video = $("#kv-video");

    $video.attr("src", videoPath);
    $video.attr("poster", posterPath);

    $video.trigger("load");
});
