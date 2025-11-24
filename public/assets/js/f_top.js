"use-strict"

// KVの動画読み込み切り替え

$(function () {
    const today = new Date();
    const month = today.getMonth() + 1;

    const videoPath = `/assets/images/kv/movie_${month}.mp4`;
    const posterPath = `/assets/images/kv/poster_${month}.jpg`;

    const $video = $("#kv-video");

    $video.attr("poster", posterPath);
    $video.attr("src", videoPath);

    $video.trigger("load");
});

// HTMLでのvideoタグ記述
// <video id="kv-video" loop autoplay muted></video>
