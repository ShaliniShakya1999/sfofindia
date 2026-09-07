<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Blog posts</h5>
    <a class="btn btn-sm btn-primary" href="<?php echo site_url('add_blog'); ?>">Add blog</a>
  </div>
  <div class="card">
    <div class="table-responsive">
      <table class="table align-items-center mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Heading</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($rows)): ?>
            <?php foreach ($rows as $r): ?>
              <tr>
                <td><?php echo (int) $r['id']; ?></td>
                <td><?php echo isset($r['heading']) ? html_escape($r['heading']) : ''; ?></td>
                <td><?php echo isset($r['status']) ? html_escape($r['status']) : ''; ?></td>
                <td>
                  <a href="<?php echo site_url('add_blog?id=' . rawurlencode(md5((string) $r['id']))); ?>">Edit</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4">No blog posts yet (or <code>blog</code> table missing).</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
