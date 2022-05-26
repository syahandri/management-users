<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2"><?= $title; ?></h2>
    </div>
    <div class="row">
        <div class="col">
            <!-- Alert failed to add user -->
            <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert alert-danger mb-2 text-center" role="alert">
                    <h6><?= $this->session->flashdata('error'); ?></h6>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('user/create'); ?>" method="post">
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

                <button type="submit" class="btn btn-primary px-4 mt-2"><i class="fa-solid fa-save"></i> Save</button>
            </form>
        </div>
    </div>
</main>