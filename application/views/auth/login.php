<div class="container px-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-7 col-lg-5 bg-light rounded-4 px-5">
            <form action="<?= base_url('auth/login'); ?>" method="POST">
                <h3 class="my-4 fw-normal text-center">Login</h3>

                <!-- Alert success register -->
                <?php if ($this->session->flashdata('success')) : ?>
                    <div class="alert alert-success mb-2 text-center" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>

                <!-- Alert failed login -->
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger mb-2 text-center" role="alert">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <div class="mb-2">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="name@rumahweb.co.id" value="<?= set_value('email'); ?>">
                    <div class="invalid-feedback">
                        <?= form_error('email'); ?>
                    </div>
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Password">
                    <div class="form-check mt-2">
                        <label class="form-check-label" for="show-password">Show Password</label>
                        <input class="form-check-input" type="checkbox" value="" id="show-password">
                    </div>
                    <div class="invalid-feedback">
                        <?= form_error('password'); ?>
                    </div>
                </div>

                <button class="w-100 btn btn-primary my-2" type="submit">Login</button>
                <div class="text-center">
                    <a href="<?= base_url('auth/register'); ?>" class="text-decoration-none">Need an account? Register</a>
                    <p class="mt-3 text-muted">Made with ❤ by Andrian Syah <?= date('Y'); ?></p>
                </div>
            </form>
        </div>
    </div>
</div>