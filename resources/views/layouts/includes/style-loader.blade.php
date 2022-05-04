{{--<style>--}}
    {{--.spinner-wrapper {--}}
        {{--position: fixed;--}}
        {{--top: 0;--}}
        {{--right: 0;--}}
        {{--bottom: 0;--}}
        {{--left: 0;--}}
        {{--z-index: 999;--}}
        {{--display: flex;--}}
        {{--align-items: center;--}}
        {{--justify-content: center;--}}
        {{--background: rgba(255, 255, 255, 0.7);--}}
    {{--}--}}

    {{--.loading .spinner-wrapper{--}}
        {{--background: #fff;--}}
    {{--}--}}

    {{--.cubes {--}}
        {{--width: 40px;--}}
        {{--height: 40px;--}}
        {{--position: relative;--}}
    {{--}--}}

    {{--.cube1, .cube2 {--}}
        {{--background-color: #007cff;--}}
        {{--width: 20px;--}}
        {{--height: 20px;--}}
        {{--position: absolute;--}}
        {{--top: 0;--}}
        {{--left: 0;--}}

        {{---webkit-animation: sk-cubemove 1.8s infinite ease-in-out;--}}
        {{--animation: sk-cubemove 1.8s infinite ease-in-out;--}}
    {{--}--}}

    {{--.cube2 {--}}
        {{---webkit-animation-delay: -0.9s;--}}
        {{--animation-delay: -0.9s;--}}
    {{--}--}}

    {{--@-webkit-keyframes sk-cubemove {--}}
        {{--25% {--}}
            {{---webkit-transform: translateX(42px) rotate(-90deg) scale(0.5)--}}
        {{--}--}}
        {{--50% {--}}
            {{---webkit-transform: translateX(42px) translateY(42px) rotate(-180deg)--}}
        {{--}--}}
        {{--75% {--}}
            {{---webkit-transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5)--}}
        {{--}--}}
        {{--100% {--}}
            {{---webkit-transform: rotate(-360deg)--}}
        {{--}--}}
    {{--}--}}

    {{--@keyframes sk-cubemove {--}}
        {{--25% {--}}
            {{--transform: translateX(42px) rotate(-90deg) scale(0.5);--}}
            {{---webkit-transform: translateX(42px) rotate(-90deg) scale(0.5);--}}
        {{--}--}}
        {{--50% {--}}
            {{--transform: translateX(42px) translateY(42px) rotate(-179deg);--}}
            {{---webkit-transform: translateX(42px) translateY(42px) rotate(-179deg);--}}
        {{--}--}}
        {{--50.1% {--}}
            {{--transform: translateX(42px) translateY(42px) rotate(-180deg);--}}
            {{---webkit-transform: translateX(42px) translateY(42px) rotate(-180deg);--}}
        {{--}--}}
        {{--75% {--}}
            {{--transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5);--}}
            {{---webkit-transform: translateX(0px) translateY(42px) rotate(-270deg) scale(0.5);--}}
        {{--}--}}
        {{--100% {--}}
            {{--transform: rotate(-360deg);--}}
            {{---webkit-transform: rotate(-360deg);--}}
        {{--}--}}
    {{--}--}}
{{--</style>--}}

{{-- CAR --}}
<style>
    {{--.loading #appLoader{--}}
        {{--position: fixed;--}}
        {{--top: 0;--}}
        {{--left: 0;--}}
        {{--right: 0;--}}
        {{--bottom: 0;--}}
        {{--z-index: 99999;--}}
        {{--background: #fff;--}}
    {{--}--}}
    {{--.cssload-body {--}}
        {{--position: absolute;--}}
        {{--top: 0;--}}
        {{--left: 0;--}}
        {{--right: 0;--}}
        {{--bottom: 0;--}}
        {{--margin: auto;--}}
        {{--width: 100px;--}}
        {{--height: 100px;--}}
        {{--background-image: url({{ asset('main_layout/images/svg/truck.svg') }});--}}
        {{--animation: speeder 1.36s linear infinite;--}}
        {{---o-animation: speeder 1.36s linear infinite;--}}
        {{---ms-animation: speeder 1.36s linear infinite;--}}
        {{---webkit-animation: speeder 1.36s linear infinite;--}}
        {{---moz-animation: speeder 1.36s linear infinite;--}}
    {{--}--}}

    {{--.cssload-body > span {--}}
        {{--height: 5px;--}}
        {{--width: 34px;--}}
        {{--background: transparent;--}}
        {{--position: absolute;--}}
        {{--top: 67px;--}}
        {{--left: -20px;--}}
    {{--}--}}

    {{--.cssload-body > span > span:nth-child(1){--}}
        {{--width: 30px;--}}
        {{--height: 42px;--}}
        {{--top: -22px;--}}
        {{--left: -14px;--}}
        {{--position: absolute;--}}
        {{--border-radius: 50%;--}}
        {{--background: url('/main_layout/images/landing/poof.svg') 0 50% no-repeat;--}}
        {{--background-size: contain;--}}
        {{---webkit-transform: rotate(22deg);--}}
        {{---moz-transform: rotate(22deg);--}}
        {{---ms-transform: rotate(22deg);--}}
        {{---o-transform: rotate(22deg);--}}
        {{--transform: rotate(22deg);--}}
        {{--animation: fazer1 0.68s linear infinite;--}}
        {{---o-animation: fazer1 0.68s linear infinite;--}}
        {{---ms-animation: fazer1 0.68s linear infinite;--}}
        {{---webkit-animation: fazer1 0.68s linear infinite;--}}
        {{---moz-animation: fazer1 0.68s linear infinite;--}}
    {{--}--}}

    {{--.cssload-longfazers {--}}
        {{--position: absolute;--}}
        {{--width: 100%;--}}
        {{--height: 100%;--}}
    {{--}--}}

    {{--.cssload-longfazers span {--}}
        {{--position: absolute;--}}
        {{--height: 2px;--}}
        {{--width: 20%;--}}
        {{--background: #007cff;--}}
    {{--}--}}

    {{--.cssload-longfazers span:nth-child(1) {--}}
        {{--top: 20%;--}}
        {{--animation: cssload-lf 2.04s linear infinite;--}}
        {{---o-animation: cssload-lf 2.04s linear infinite;--}}
        {{---ms-animation: cssload-lf 2.04s linear infinite;--}}
        {{---webkit-animation: cssload-lf 2.04s linear infinite;--}}
        {{---moz-animation: cssload-lf 2.04s linear infinite;--}}
        {{--animation-delay: -17s;--}}
        {{---o-animation-delay: -17s;--}}
        {{---ms-animation-delay: -17s;--}}
        {{---webkit-animation-delay: -17s;--}}
        {{---moz-animation-delay: -17s;--}}
    {{--}--}}

    {{--.cssload-longfazers span:nth-child(2) {--}}
        {{--top: 40%;--}}
        {{--animation: cssload-lf 2.72s linear infinite;--}}
        {{---o-animation: cssload-lf 2.72s linear infinite;--}}
        {{---ms-animation: cssload-lf 2.72s linear infinite;--}}
        {{---webkit-animation: cssload-lf 2.72s linear infinite;--}}
        {{---moz-animation: cssload-lf 2.72s linear infinite;--}}
        {{--animation-delay: -3.4s;--}}
        {{---o-animation-delay: -3.4s;--}}
        {{---ms-animation-delay: -3.4s;--}}
        {{---webkit-animation-delay: -3.4s;--}}
        {{---moz-animation-delay: -3.4s;--}}
    {{--}--}}

    {{--.cssload-longfazers span:nth-child(3) {--}}
        {{--top: 60%;--}}
        {{--animation: cssload-lf 2.04s linear infinite;--}}
        {{---o-animation: cssload-lf 2.04s linear infinite;--}}
        {{---ms-animation: cssload-lf 2.04s linear infinite;--}}
        {{---webkit-animation: cssload-lf 2.04s linear infinite;--}}
        {{---moz-animation: cssload-lf 2.04s linear infinite;--}}
    {{--}--}}

    {{--.cssload-longfazers span:nth-child(4) {--}}
        {{--top: 80%;--}}
        {{--animation: cssload-lf 1.7s linear infinite;--}}
        {{---o-animation: cssload-lf 1.7s linear infinite;--}}
        {{---ms-animation: cssload-lf 1.7s linear infinite;--}}
        {{---webkit-animation: cssload-lf 1.7s linear infinite;--}}
        {{---moz-animation: cssload-lf 1.7s linear infinite;--}}
        {{--animation-delay: -10.2s;--}}
        {{---o-animation-delay: -10.2s;--}}
        {{---ms-animation-delay: -10.2s;--}}
        {{---webkit-animation-delay: -10.2s;--}}
        {{---moz-animation-delay: -10.2s;--}}
    {{--}--}}



    {{--@keyframes fazer1 {0% {left: 0;} 100% {left: -78px;opacity: 0;}}--}}



    {{--@-o-keyframes fazer1 {0% {left: 0;} 100% {left: -78px;opacity: 0;}}--}}


    {{--@-ms-keyframes fazer1 {0% {left: 0;} 100% {left: -78px;opacity: 0;}}--}}



    {{--@-webkit-keyframes fazer1 {0% {left: 0;} 100% {left: -78px;opacity: 0;}}--}}


    {{--@-moz-keyframes fazer1 {0% {left: 0;} 100% {left: -78px;opacity: 0;}}--}}



    {{--@keyframes fazer2 {0% {left: 0;} 100% {left: -97px;opacity: 0;}}--}}



    {{--@-o-keyframes fazer2 {0% {left: 0;} 100% {left: -97px;opacity: 0;}}--}}



    {{--@-ms-keyframes fazer2 {0% {left: 0;} 100% {left: -97px;opacity: 0;}}--}}



    {{--@-webkit-keyframes fazer2 {0% {left: 0;} 100% {left: -97px;opacity: 0;}}--}}



    {{--@-moz-keyframes fazer2 {0% {left: 0;} 100% {left: -97px;opacity: 0;}}--}}


    {{--@keyframes fazer3 {0% {left: 0;} 100% {left: -49px;opacity: 0;}}--}}



    {{--@-o-keyframes fazer3 {0% {left: 0;} 100% {left: -49px;opacity: 0;}}--}}



    {{--@-ms-keyframes fazer3 {0% {left: 0;} 100% {left: -49px;opacity: 0;}}--}}



    {{--@-webkit-keyframes fazer3 {0% {left: 0;} 100% {left: -49px;opacity: 0;}}--}}


    {{--@-moz-keyframes fazer3 {0% {left: 0;} 100% {left: -49px;opacity: 0;}}--}}

    {{--@keyframes fazer4 {0% {left: 0;} 100% {left: -146px;opacity: 0;}}--}}

    {{--@-o-keyframes fazer4 {0% {left: 0;} 100% {left: -146px;opacity: 0;}}--}}

    {{--@-ms-keyframes fazer4 {0% {left: 0;} 100% {left: -146px;opacity: 0;}}--}}

    {{--@-webkit-keyframes fazer4 {0% {left: 0;} 100% {left: -146px;opacity: 0;}}--}}

    {{--@-moz-keyframes fazer4 {0% {left: 0;} 100% {left: -146px;opacity: 0;}}--}}

    {{--@keyframes speeder {--}}
        {{--0% { transform: translate(2px, 1px) rotate(0deg); }--}}
        {{--10% { transform: translate(-1px, -3px) rotate(-1deg); }--}}
        {{--20% { transform: translate(-2px, 0px) rotate(1deg); }--}}
        {{--30% { transform: translate(1px, 2px) rotate(0deg); }--}}
        {{--40% { transform: translate(1px, -1px) rotate(1deg); }--}}
        {{--50% { transform: translate(-1px, 3px) rotate(-1deg); }--}}
        {{--60% { transform: translate(-1px, 1px) rotate(0deg); }--}}
        {{--70% { transform: translate(3px, 1px) rotate(-1deg); }--}}
        {{--80% { transform: translate(-2px, -1px) rotate(1deg); }--}}
        {{--90% { transform: translate(2px, 1px) rotate(0deg); }--}}
        {{--100% { transform: translate(1px, -2px) rotate(-1deg); }--}}
    {{--}--}}

    {{--@-o-keyframes speeder {--}}
        {{--0% { -o-transform: translate(2px, 1px) rotate(0deg); }--}}
        {{--10% { -o-transform: translate(-1px, -3px) rotate(-1deg); }--}}
        {{--20% { -o-transform: translate(-2px, 0px) rotate(1deg); }--}}
        {{--30% { -o-transform: translate(1px, 2px) rotate(0deg); }--}}
        {{--40% { -o-transform: translate(1px, -1px) rotate(1deg); }--}}
        {{--50% { -o-transform: translate(-1px, 3px) rotate(-1deg); }--}}
        {{--60% { -o-transform: translate(-1px, 1px) rotate(0deg); }--}}
        {{--70% { -o-transform: translate(3px, 1px) rotate(-1deg); }--}}
        {{--80% { -o-transform: translate(-2px, -1px) rotate(1deg); }--}}
        {{--90% { -o-transform: translate(2px, 1px) rotate(0deg); }--}}
        {{--100% { -o-transform: translate(1px, -2px) rotate(-1deg); }--}}
    {{--}--}}

    {{--@-ms-keyframes speeder {--}}
        {{--0% { -ms-transform: translate(2px, 1px) rotate(0deg); }--}}
        {{--10% { -ms-transform: translate(-1px, -3px) rotate(-1deg); }--}}
        {{--20% { -ms-transform: translate(-2px, 0px) rotate(1deg); }--}}
        {{--30% { -ms-transform: translate(1px, 2px) rotate(0deg); }--}}
        {{--40% { -ms-transform: translate(1px, -1px) rotate(1deg); }--}}
        {{--50% { -ms-transform: translate(-1px, 3px) rotate(-1deg); }--}}
        {{--60% { -ms-transform: translate(-1px, 1px) rotate(0deg); }--}}
        {{--70% { -ms-transform: translate(3px, 1px) rotate(-1deg); }--}}
        {{--80% { -ms-transform: translate(-2px, -1px) rotate(1deg); }--}}
        {{--90% { -ms-transform: translate(2px, 1px) rotate(0deg); }--}}
        {{--100% { -ms-transform: translate(1px, -2px) rotate(-1deg); }--}}
    {{--}--}}

    {{--@-webkit-keyframes speeder {--}}
        {{--0% { -webkit-transform: translate(2px, 1px) rotate(0deg); }--}}
        {{--10% { -webkit-transform: translate(-1px, -3px) rotate(-1deg); }--}}
        {{--20% { -webkit-transform: translate(-2px, 0px) rotate(1deg); }--}}
        {{--30% { -webkit-transform: translate(1px, 2px) rotate(0deg); }--}}
        {{--40% { -webkit-transform: translate(1px, -1px) rotate(1deg); }--}}
        {{--50% { -webkit-transform: translate(-1px, 3px) rotate(-1deg); }--}}
        {{--60% { -webkit-transform: translate(-1px, 1px) rotate(0deg); }--}}
        {{--70% { -webkit-transform: translate(3px, 1px) rotate(-1deg); }--}}
        {{--80% { -webkit-transform: translate(-2px, -1px) rotate(1deg); }--}}
        {{--90% { -webkit-transform: translate(2px, 1px) rotate(0deg); }--}}
        {{--100% { -webkit-transform: translate(1px, -2px) rotate(-1deg); }--}}
    {{--}--}}

    {{--@-moz-keyframes speeder {--}}
        {{--0% { -moz-transform: translate(2px, 1px) rotate(0deg); }--}}
        {{--10% { -moz-transform: translate(-1px, -3px) rotate(-1deg); }--}}
        {{--20% { -moz-transform: translate(-2px, 0px) rotate(1deg); }--}}
        {{--30% { -moz-transform: translate(1px, 2px) rotate(0deg); }--}}
        {{--40% { -moz-transform: translate(1px, -1px) rotate(1deg); }--}}
        {{--50% { -moz-transform: translate(-1px, 3px) rotate(-1deg); }--}}
        {{--60% { -moz-transform: translate(-1px, 1px) rotate(0deg); }--}}
        {{--70% { -moz-transform: translate(3px, 1px) rotate(-1deg); }--}}
        {{--80% { -moz-transform: translate(-2px, -1px) rotate(1deg); }--}}
        {{--90% { -moz-transform: translate(2px, 1px) rotate(0deg); }--}}
        {{--100% { -moz-transform: translate(1px, -2px) rotate(-1deg); }--}}
    {{--}--}}

    {{--@keyframes cssload-lf {--}}
        {{--0% {left: 200%;}--}}
        {{--100% {left: -200%;opacity: 0;}--}}
    {{--}--}}

    {{--@-o-keyframes cssload-lf {--}}
        {{--0% {left: 200%;}--}}
        {{--100% {left: -200%;opacity: 0;}--}}
    {{--}--}}

    {{--@-ms-keyframes cssload-lf {--}}
        {{--0% {left: 200%;}--}}
        {{--100% {left: -200%;opacity: 0;}--}}
    {{--}--}}

    {{--@-webkit-keyframes cssload-lf {--}}
        {{--0% {left: 200%;}--}}
        {{--100% {left: -200%;opacity: 0;}--}}
    {{--}--}}

    {{--@-moz-keyframes cssload-lf {--}}
        {{--0% {left: 200%;}--}}
        {{--100% {left: -200%;opacity: 0;}--}}
    {{--}--}}
</style>