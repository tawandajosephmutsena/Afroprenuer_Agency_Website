@aware(['page'])

@props([
    'slides' // Array of slides with dynamic content
])


<style>

/* carousel */
.carousel{
    height: 95vh;
    width: 100vw;
    overflow: hidden;
    position: relative;
}
.carousel .list .item{
    width: 100%;
    height: 100%;
    position: absolute;
    inset: 0 0 0 0;
}
.carousel .list .item img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.carousel .list .item .content{
    position: absolute;
    drop-shadow: 90;
    top: 20%;
    width: 1140px;
    max-width: 80%;
    left: 50%;
    transform: translateX(-50%);
    padding-right: 30%;
    box-sizing: border-box;
    color: #fff;
    text-shadow: 0 5px 10px #0004;
}
.carousel .list .item .author{
    font-weight: bold;
    letter-spacing: 10px;
}
.carousel .list .item .title,
.carousel .list .item .topic{
    font-size: 5em;
    font-weight: bold;
    line-height: 1.3em;
}
.carousel .list .item .topic{
    color: #f1683a;
}
.carousel .list .item .buttons{
    display: grid;
    grid-template-columns: repeat(2, 130px);
    grid-template-rows: 40px;
    gap: 5px;
    margin-top: 20px;
}
.carousel .list .item .buttons button{
    border: none;
    background-color: #f1683a;
    letter-spacing: 3px;
    font-family: Poppins;
    font-weight: 500;
}
.carousel .list .item .buttons button:nth-child(2){
    background-color: transparent;
    border: 1px solid #fff;
    color: #eee;
}
/* thumbnail */
.thumbnail{
    position: absolute;
    bottom: 50px;
    left: 50%;
    width: max-content;
    z-index: 100;
    display: flex;
    gap: 20px;
}
.thumbnail .item{
    width: 150px;
    height: 220px;
    flex-shrink: 0;
    position: relative;
}
.thumbnail .item img{
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
}
.thumbnail .item .content{
    color: #fff;
    position: absolute;
    bottom: 10px;
    left: 10px;
    right: 10px;
}
.thumbnail .item .content .title{
    font-weight: 500;
}
.thumbnail .item .content .description{
    font-weight: 300;
}
/* arrows */
.arrows{
    position: absolute;
    top: 80%;
    right: 52%;
    z-index: 100;
    width: 300px;
    max-width: 30%;
    display: flex;
    gap: 10px;
    align-items: center;
}
.arrows button{
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #eee4;
    border: none;
    color: #fff;
    font-family: monospace;
    font-weight: bold;
    transition: .5s;
}
.arrows button:hover{
    background-color: #fff;
    color: #000;
}

/* animation */
.carousel .list .item:nth-child(1){
    z-index: 1;
}

/* animation text in first item */

.carousel .list .item:nth-child(1) .content .author,
.carousel .list .item:nth-child(1) .content .title,
.carousel .list .item:nth-child(1) .content .topic,
.carousel .list .item:nth-child(1) .content .des,
.carousel .list .item:nth-child(1) .content .buttons
{
    transform: translateY(50px);
    filter: blur(20px);
    opacity: 0;
    animation: showContent .5s 1s linear 1 forwards;
}
@keyframes showContent{
    to{
        transform: translateY(0px);
        filter: blur(0px);
        opacity: 1;
    }
}
.carousel .list .item:nth-child(1) .content .title{
    animation-delay: 1.2s!important;
}
.carousel .list .item:nth-child(1) .content .topic{
    animation-delay: 1.4s!important;
}
.carousel .list .item:nth-child(1) .content .des{
    animation-delay: 1.6s!important;
}
.carousel .list .item:nth-child(1) .content .buttons{
    animation-delay: 1.8s!important;
}
/* create animation when next click */
.carousel.next .list .item:nth-child(1) img{
    width: 150px;
    height: 220px;
    position: absolute;
    bottom: 50px;
    left: 50%;
    border-radius: 30px;
    animation: showImage .5s linear 1 forwards;
}
@keyframes showImage{
    to{
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 0;
    }
}

.carousel.next .thumbnail .item:nth-last-child(1){
    overflow: hidden;
    animation: showThumbnail .5s linear 1 forwards;
}
.carousel.prev .list .item img{
    z-index: 100;
}
@keyframes showThumbnail{
    from{
        width: 0;
        opacity: 0;
    }
}
.carousel.next .thumbnail{
    animation: effectNext .5s linear 1 forwards;
}

@keyframes effectNext{
    from{
        transform: translateX(150px);
    }
}

/* running time */

.carousel .time{
    position: absolute;
    z-index: 1000;
    width: 0%;
    height: 3px;
    background-color: #f1683a;
    left: 0;
    top: 0;
}

.carousel.next .time,
.carousel.prev .time{
    animation: runningTime 3s linear 1 forwards;
}
@keyframes runningTime{
    from{ width: 100%}
    to{width: 0}
}


/* prev click */

.carousel.prev .list .item:nth-child(2){
    z-index: 2;
}

.carousel.prev .list .item:nth-child(2) img{
    animation: outFrame 0.5s linear 1 forwards;
    position: absolute;
    bottom: 0;
    left: 0;
}
@keyframes outFrame{
    to{
        width: 150px;
        height: 220px;
        bottom: 50px;
        left: 50%;
        border-radius: 20px;
    }
}

.carousel.prev .thumbnail .item:nth-child(1){
    overflow: hidden;
    opacity: 0;
    animation: showThumbnail .5s linear 1 forwards;
}
.carousel.next .arrows button,
.carousel.prev .arrows button{
    pointer-events: none;
}
.carousel.prev .list .item:nth-child(2) .content .author,
.carousel.prev .list .item:nth-child(2) .content .title,
.carousel.prev .list .item:nth-child(2) .content .topic,
.carousel.prev .list .item:nth-child(2) .content .des,
.carousel.prev .list .item:nth-child(2) .content .buttons
{
    animation: contentOut 1.5s linear 1 forwards!important;
}

@keyframes contentOut{
    to{
        transform: translateY(-150px);
        filter: blur(20px);
        opacity: 0;
    }
}
@media screen and (max-width: 678px) {
    .carousel .list .item .content{
        padding-right: 0;
    }
    .carousel .list .item .content .title{
        font-size: 30px;
    }
}
</style>

 <!-- carousel -->
 <div class="carousel">
    <div class="list">
        @foreach($slides as $slide)
            <div class="item">
                <!-- Slide Background Image -->
                @if($slide['background_image_url'])
                    <img src="{{ $slide['background_image_url'] }}" class="w-full h-full object-cover">
                @endif
                <div class="content">
                    <div class="author">{{ $slide['author'] ?? '' }}</div>
                    <div class="title">{{ $slide['title'] }}</div>
                    <div class="topic">{{ $slide['subtitle'] ?? '' }}</div>
                    <div class="des">
                        {{ $slide['description'] ?? '' }}
                    </div>
                    <div class="buttons">
                        @foreach($slide['buttons'] as $button)
                            <a href="{{ $button['url'] }}" class="btn">{{ $button['label'] }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Thumbnails for Each Slide -->
    <div class="thumbnail">
        @foreach($slides as $slide)
            <div class="item">
                @if($slide['background_image_url'])
                    <img src="{{ $slide['background_image_url'] }}" class="w-full h-full object-cover rounded-lg" />
                @endif
                <div class="content">
                    <div class="title">{{ $slide['title'] }}</div>
                    <div class="description">{{ $slide['subtitle'] ?? '' }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Navigation Arrows -->
    <div class="arrows">
        <button id="prev"><</button>
        <button id="next">></button>
    </div>
    <div class="time"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let nextDom = document.getElementById('next');
        let prevDom = document.getElementById('prev');

        let carouselDom = document.querySelector('.carousel');
        let SliderDom = carouselDom.querySelector('.carousel .list');
        let thumbnailBorderDom = document.querySelector('.carousel .thumbnail');
        let thumbnailItemsDom = thumbnailBorderDom.querySelectorAll('.item');
        let timeDom = document.querySelector('.carousel .time');

        thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
        let timeRunning = 3000;
        let timeAutoNext = 7000;

        nextDom.onclick = function() {
            showSlider('next');
        }

        prevDom.onclick = function() {
            showSlider('prev');
        }

        let runTimeOut;
        let runNextAuto = setTimeout(() => {
            nextDom.click();
        }, timeAutoNext);

        function showSlider(type){
            let SliderItemsDom = SliderDom.querySelectorAll('.carousel .list .item');
            let thumbnailItemsDom = document.querySelectorAll('.carousel .thumbnail .item');

            if(type === 'next'){
                SliderDom.appendChild(SliderItemsDom[0]);
                thumbnailBorderDom.appendChild(thumbnailItemsDom[0]);
                carouselDom.classList.add('next');
            } else {
                SliderDom.prepend(SliderItemsDom[SliderItemsDom.length - 1]);
                thumbnailBorderDom.prepend(thumbnailItemsDom[thumbnailItemsDom.length - 1]);
                carouselDom.classList.add('prev');
            }
            clearTimeout(runTimeOut);
            runTimeOut = setTimeout(() => {
                carouselDom.classList.remove('next');
                carouselDom.classList.remove('prev');
            }, timeRunning);

            clearTimeout(runNextAuto);
            runNextAuto = setTimeout(() => {
                nextDom.click();
            }, timeAutoNext);
        }
    });
</script>
