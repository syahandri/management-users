<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2"><?= $title; ?></h2>
    </div>
    <div class="row">
        <div class="col">
            <!-- Alert fail to edit / delete user -->
            <?php if ($this->session->flashdata('error')) : ?>
                <div class="alert alert-danger mb-3 text-center" role="alert">
                    <h6><?= $this->session->flashdata('error'); ?></h6>
                </div>
            <?php endif; ?>

            <!-- Alert success to add / update / delete user -->
            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success mb-3 text-center" role="alert">
                    <h6><?= $this->session->flashdata('success'); ?></h6>
                </div>
            <?php endif; ?>

            <a href="<?= base_url('user/create'); ?>" class="btn btn-primary btn-sm mb-3 px-3"><i class="fa-solid fa-plus"></i> Add User</a>
            <div class="table-responsive">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($users['data'] as $user) : ?>
                            <tr>
                                <td><?= $no + $page_numb++; ?></td>
                                <td><?= $user['id']; ?></td>
                                <td><?= $user['firstName']; ?></td>
                                <td><?= $user['lastName']; ?></td>
                                <td>
                                    <div class="d-flex flex-wrap">
                                        <a href="<?= base_url('user/edit/' . $user['id'] . ''); ?>" class="btn btn-success btn-sm me-0 me-sm-2 mb-2 mb-sm-0"><i class="fa-solid fa-pen"></i> Edit</a>
                                        <form action="<?= base_url('user/delete/' . $user['id'] . ''); ?>" method="post">
                                            <input type="hidden" name="_method" value="delete">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure the user will be deleted?')"><i class="fa-solid fa-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="d-flex justify-content-end">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link <?= $page < 1 ? 'disabled' : ''; ?>" href="?page=<?= $page - 1; ?>">
                                    <span>&laquo;</span>
                                </a>
                            </li>
                            <?php for ($i = 0; $i < $totalPage; $i++) : ?>
                                <li class="page-item"><a class="page-link <?= $i == $page ? 'active' : ''; ?>" href="?page=<?= $i; ?>"><?= $i + 1; ?></a></li>
                            <?php endfor; ?>
                            <li class="page-item">
                                <a class="page-link  <?= $page >= $totalPage - 1 ? 'disabled' : ''; ?>" href="?page=<?= $page + 1; ?>">
                                    <span>&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>