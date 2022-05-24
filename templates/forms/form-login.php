<div class="p-3 position-relative background-white h-100">
<?php if(isset($messages_template) && ! empty($messages_template)):?>
    <?=$messages_template;?>
<?php endif;?>
    <form action="/login/process" method="POST">
        <div class="hidden">
            <input type="hidden" name="form_name" value="form_user_login">
        </div>
        <!-- HEADING: -->
        <div class="row">
            <div class="col">
                <h3 class="h3 mb-3 fw-normal border-bottom-dotted pb-2">Login</h3>
                <p class="mb-4 text-muted">If you want to login as Admin use <span class="fw-bolder">admin:swiezemlekotez</span></p>
            </div>
        </div>

        <div class="row">
            <div class="col position-relative pb-5">
                <!-- USERNAME -->
                <div class="row row-flex mb-3">
                    <label for="usernameInput" class="col-12 col-md-4 col-form-label fw-bolder">Login:</label>
                    <div class="col-12 col-md-8">
                        <input type="text" name="username" class="form-control" id="usernameInput" value="username1" />
                    </div>
                </div>
                <!-- PASSWORD: -->
                <div class="row  row-flex mb-3">
                    <label for="passwordInput" class="col-12 col-md-4 col-form-label fw-bolder">Password:</label>
                    <div class="col-12 col-md-8">
                        <input type="password" name="password" value="lubiemaslo" class="form-control" id="passwordInput" />
                    </div>
                </div>
                <!-- SPACER: -->
                <div class="row mb-3">
                    <div class="col">
                        <hr class="divider" />
                    </div>
                </div>
                <!-- SUBMIT: -->
                <div class="row position-absolute bottom w-100">
                    <div class="col-sm">
                        <button class="w-100 btn btn-lg btn-success" type="submit">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>