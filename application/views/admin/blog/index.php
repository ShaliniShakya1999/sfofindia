<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4 min-vh-80">
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-6">
            <h4 class="mb-0 font-weight-bolder text-dark">Blog Management 📝</h4>
            <p class="text-sm text-muted mb-0">Publish stories, news, and updates to keep your audience engaged.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="<?php echo site_url('blog_manager/form'); ?>" class="btn bg-gradient-primary mb-0">
                <i class="material-symbols-rounded align-middle me-1">add_circle</i> Write New Post
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius:15px;">
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-4">Post Details</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Author & Date</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($blogs)): foreach($blogs as $row): ?>
                        <tr>
                            <td class="px-4">
                                <div class="d-flex px-2 py-1">
                                    <div>
                                        <?php 
                                            $raw_img = (string)$row['image'];
                                            $final_src = '';
                                            if ($raw_img !== '') {
                                                if (strpos($raw_img, 'http') === 0) {
                                                    $final_src = $raw_img;
                                                } elseif (strpos($raw_img, 'uploads/') === 0 || strpos($raw_img, 'img/') === 0) {
                                                    $final_src = base_url($raw_img);
                                                } else {
                                                    $final_src = base_url('uploads/' . $raw_img);
                                                }
                                            }
                                        ?>
                                        <?php if($final_src !== ''): ?>
                                            <img src="<?php echo $final_src; ?>" class="avatar avatar-sm me-3 border-radius-lg" alt="post">
                                        <?php else: ?>
                                            <div class="avatar avatar-sm me-3 border-radius-lg bg-gray-200 d-flex align-items-center justify-content-center">
                                                <i class="material-symbols-rounded text-secondary">image</i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm font-weight-bold"><?php echo html_escape($row['heading']); ?></h6>
                                        <p class="text-xs text-secondary mb-0"><?php echo html_escape($row['slug']); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0"><?php echo html_escape($row['postedBy']); ?></p>
                                <p class="text-xs text-secondary mb-0"><?php echo date('d M Y', strtotime($row['postedDate'])); ?></p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input status-toggle" type="checkbox" 
                                           data-id="<?php echo md5($row['id']); ?>" 
                                           <?php echo ($row['status'] == 'Active') ? 'checked' : ''; ?>>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?php echo site_url('blog_manager/form/'.md5($row['id'])); ?>" 
                                       class="btn btn-link text-primary p-0 mb-0" data-bs-toggle="tooltip" title="Edit Post">
                                        <i class="material-symbols-rounded text-lg">edit_note</i>
                                    </a>
                                    <button onclick="confirmDelete('<?php echo md5($row['id']); ?>')" 
                                            class="btn btn-link text-danger p-0 mb-0" data-bs-toggle="tooltip" title="Delete Post">
                                        <i class="material-symbols-rounded text-lg">delete_forever</i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <h6 class="text-muted">No blog posts found. Start writing today!</h6>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Delete this post?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e91e63',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?php echo site_url('blog_manager/delete/'); ?>' + id;
        }
    })
}

document.querySelectorAll('.status-toggle').forEach(el => {
    el.addEventListener('change', function() {
        const id = this.getAttribute('data-id');
        fetch('<?php echo site_url('blog_manager/toggle_status/'); ?>' + id)
            .then(res => res.text())
            .then(status => {
                // Done
            });
    });
});
</script>
