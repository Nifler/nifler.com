<style>
    .api-wrap-loading {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000
    }
    .api-wrap-loading:focus {
        outline: none
    }
    .api-wrap-loading_active {
        display: flex;
    }
    .api-loader {
        position: relative
    }
    .api-loader:focus {
        outline: none
    }
    .api-loader__wrapper {
        width: 48px;
        height: 48px;
        margin: 0 auto;
        animation: container-rotate 1568ms linear infinite
    }
    .api-loader__wrapper:before {
        position: absolute;
        content: "";
        height: 100%;
        width: 100%;
        border: 2px solid #ddd;
        border-radius: 50%
    }
    .api-loader__window {
        width: 200px;
        height: 135px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        box-shadow: 0 2px 13px 0 rgba(68, 68, 68, .5)
    }
    .api-loader__window:focus {
        outline: none
    }
    .api-loader__layer {
        position: absolute;
        width: 100%;
        height: 100%;
        border-color: #ff9000;
        animation: fill-unfill-rotate 5332ms cubic-bezier(.4, 0, .2, 1) infinite both
    }
    .api-loader__circle-clipper {
        position: relative;
        width: 50%;
        height: 100%;
        overflow: hidden;
        border-color: inherit
    }
    .api-loader__circle-clipper .api-loader__circle {
        width: 200%;
        height: 100%;
        border: 2px solid #ff9000;
        border-bottom-color: transparent;
        border-radius: 50%;
        animation: none
    }
    .api-loader__circle-clipper--left .api-loader__circle {
        left: 0;
        border-right-color: transparent;
        transform: rotate(129deg);
        animation: left-spin 1333ms cubic-bezier(.4, 0, .2, 1) infinite both
    }
    @keyframes container-rotate {
        to {
            transform: rotate(1turn)
        }
    }
    @keyframes fill-unfill-rotate {
        12.5% {
            transform: rotate(135deg)
        }
        25% {
            transform: rotate(270deg)
        }
        37.5% {
            transform: rotate(405deg)
        }
        50% {
            transform: rotate(540deg)
        }
        62.5% {
            transform: rotate(675deg)
        }
        75% {
            transform: rotate(810deg)
        }
        87.5% {
            transform: rotate(945deg)
        }
        to {
            transform: rotate(3turn)
        }
    }
    @keyframes left-spin {
        0% {
            transform: rotate(130deg)
        }
        50% {
            transform: rotate(-5deg)
        }
        to {
            transform: rotate(130deg)
        }
    }
    @keyframes right-spin {
        0% {
            transform: rotate(-130deg)
        }
        50% {
            transform: rotate(5deg)
        }
        to {
            transform: rotate(-130deg)
        }
    }


    * {
        box-sizing: border-box
    }
    *::before {
        box-sizing: border-box
    }
    *::after {
        box-sizing: border-box
    }
</style>

<div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;">
    <div class="api-wrap-loading api-wrap-loading_active">
        <div class="api-loader__window">
            <p style="color:#636b6f">Uploading</p>
            <div class="api-loader">
                <div class="api-loader__wrapper">
                    <div class="api-loader__layer">
                        <div class="api-loader__circle-clipper api-loader__circle-clipper--left">
                            <div class="api-loader__circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
