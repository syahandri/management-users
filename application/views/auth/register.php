<div class="container px-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 bg-light rounded-4 px-5">
            <form action="<?= base_url('auth/register'); ?>" method="POST">
                <h3 class="my-4 fw-normal text-center">Register</h3>

                <!-- Alert failed register -->
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger mb-2 text-center" role="alert">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <div class="mb-2">
                    <label for="firtName" class="form-label">First Name</label>
                    <input type="text" class="form-control text-capitalize <?= form_error('firstName') ? 'is-invalid' : ''; ?>" id="firstName" name="firstName" placeholder="First name" value="<?= set_value('firstName'); ?>">
                    <div class="invalid-feedback">
                        <?= form_error('firstName'); ?>
                    </div>
                </div>
                <div class="mb-2">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control text-capitalize <?= form_error('lastName') ? 'is-invalid' : ''; ?>" id="lastName" name="lastName" placeholder="Last name" value="<?= set_value('lastName'); ?>">
                    <div class="invalid-feedback">
                        <?= form_error('lastName'); ?>
                    </div>
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="example@rumahweb.co.id" value="<?= set_value('email'); ?>">
                    <div class="invalid-feedback">
                        <?= form_error('email'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password">
                        <div class="invalid-feedback">
                            <?= form_error('password'); ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control <?= form_error('confirm_password') ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                        <div class="invalid-feedback">
                            <?= form_error('confirm_password'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" value="" id="show-password">
                    <label class="form-check-label" for="show-password">Show Password</label>
                </div>

                <button class="w-100 btn btn-primary my-2" type="submit">Register</button>
                <div class="text-center">
                    <a href="<?= base_url('auth/login'); ?>" class="text-decoration-none">Already have an account? Login</a>
                    <p class="mt-3 text-muted">Made with ❤ by Andrian Syah <?= date('Y'); ?></p>
                </div>
            </form>
        </div>
    </div>
</div>