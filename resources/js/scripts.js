function displayTrailer(flag){
    if(flag){
        var url = $("#youtubeUrl").text();
        var frame = $("#trailerFrame");
        var closeButton = $("#closeButton");
        var trailerFrame = $("#trailerFrame");

        frame.addClass("trailer");
        var left = (document.documentElement.clientWidth-848)/2;
        var top = (document.documentElement.clientHeight-480)/2;

        frame.css("left",left);
        frame.css("top",top);

        closeButton.css("left",left+848-30);
        closeButton.css("top",top-30);
        closeButton.css("visibility","visible");
        trailerFrame.css("visibility","visible");


        $("#header").addClass("blur");
        $("#movieInformation").addClass("blur");
        $("#ticketInformation").addClass("blur");
        $("#footer").addClass("blur");
        frame.attr("src",url);
        frame.fadeIn();
    }else{
        var frame = $("#trailerFrame");
        var closeButton = $("#closeButton");
        frame.removeClass("trailer");
        frame.attr("src","");
        closeButton.css("visibility","hidden");
        $("#header").removeClass("blur");
        $("#ticketInformation").removeClass("blur");
        $("#movieInformation").removeClass("blur");
        $("#footer").removeClass("blur");
        frame.fadeOut();
    }
}

function previewFile(){
    var preview = document.querySelector('img'); //selects the query named img
    var file    = document.querySelector('input[type=file]').files[0]; //sames as here
    var reader  = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file); //reads the data as a URL
    } else {
        preview.src = "";
    }
}

(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-76097959-1', 'auto');
ga('send', 'pageview');

