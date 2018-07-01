<style>
    .hiring-card .card {
        bottom: 20px;
        right: 0;
        position: fixed;
        width: 225px;
        height: auto;
        background: white;
        overflow-x: auto;
        z-index: 10;
    }

    .hiring-card-event > .card-action {
        display: flex;
        box-sizing: border-box;
        align-items: center;
    }

    @media only screen and (max-width: 768px) {
        #hiring {
            display: none
        }
    }

</style>
<section id="hiring">
    <div class="container hiring-card">
        <div class="card mdc-elevation--z5">
            <div class="card-image">
                <img src="{{ url('img/hiring.jpg') }}">
            </div>
            <div class="card-action" align="center">
                <a role="button" href="https://careers.smartrecruiters.com/IntegraSafeInc" class="mdc-button mdc-ripple-upgraded">
                    Apply Here
                    <i class="material-icons mdc-button__icon">assignment</i>
                </a>
            </div>
        </div>
    </div>
</section>
