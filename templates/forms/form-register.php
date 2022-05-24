<div class="p-3 background-white h-100">
<?php if(isset($messages) && ! empty($messages)):?>
    <?php require(__DIR__ . '/../common/messages.php');?>
<?php endif;?>
    <form action="/register/process" method="POST">
        <div class="hidden">
            <input type="hidden" name="form_name" value="form_register">
        </div>
        <div class="row">
            <div class="col">
                <h3 class="h3 mb-3 fw-normal border-bottom-dotted pb-2">Register</h3>
                <p class="mb-4 text-muted">Vivamus nec congue enim. Nullam rutrum ultrices sapien. Morbi blandit, ligula vel pulvinar suscipit, nisi leo imperdiet est, sed finibus eros augue ut sapien. </p>
            </div>
        </div>
        <div class="row">
            <div class="col position-relative pb-5">
                <!-- USERNAME: -->
                <div class="row mb-3">
                    <label for="usernameInput" class="col-12 col-md-4 col-form-label fw-bolder">Username:</label>
                    <div class="col-12 col-md-8">
                        <input type="text" name="username" value="" class="form-control" id="usernameInput" placeholder="Username" />
                    </div>
                </div>
                <!-- PASSWORD: -->
                <div class="row mb-3">
                    <label for="passwordInput" class="col-12 col-md-4 col-form-label fw-bolder">Password:</label>
                    <div class="col-12 col-md-8">
                        <input type="text" name="password" value="" class="form-control" id="passwordInput" placeholder="Password" />
                    </div>
                </div>
                <!-- CONFIRM PASSWORD: -->
                <div class="row mb-3">
                    <label for="passwordConfirmInput" class="col-12 col-md-4 col-form-label fw-bolder">Confirm Password:</label>
                    <div class="col-12 col-md-8">
                        <input type="text" name="password_confirm" value="" class="form-control" id="passwordConfirmInput" placeholder="Confirm Password" />
                    </div>
                </div>
                <!-- SPACER: -->
                <div class="row mb-3">
                    <div class="col">
                        <hr class="divider" />
                    </div>
                </div>
                <!-- BUTTON: -->
                <div class="row position-absolute bottom w-100">
                    <div class="col-sm">
                        <button class="w-100 btn btn-lg btn-success" type="submit">Register</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>