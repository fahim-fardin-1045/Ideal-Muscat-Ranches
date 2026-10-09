<?php require '../includes/app.php';
admin();
require 'layout.php';
$counts = db()->query('SELECT COUNT(*) total,COALESCE(SUM(published=1),0) published,COALESCE(SUM(published=0),0) drafts FROM entries')->fetch();
$messages = (int)db()->query('SELECT COUNT(*) FROM messages')->fetchColumn();
$recent = db()->query('SELECT title,kind,published FROM entries ORDER BY id DESC LIMIT 5')->fetchAll();
$enquiries = db()->query('SELECT name,created_at FROM messages ORDER BY id DESC LIMIT 4')->fetchAll();
top('Dashboard'); ?><section class="welcome-banner">
    <div>
        <h2>Welcome to your workspace</h2>
        <p>Manage your company content and stay on top of enquiries.</p>
    </div><a class="btn-company" href="entries.php?new=1">+ Add content</a>
</section>
<div class="stat-grid"><?php foreach ([['Content records', $counts['total'], 'lavender'], ['Published', $counts['published'], 'blue'], ['Drafts', $counts['drafts'], 'peach'], ['Enquiries', $messages, 'mint']] as $c): ?><a href="<?= $c[0] === 'Enquiries' ? 'messages.php' : 'entries.php' ?>" class="stat-card <?= $c[2] ?>"><span class="stat-icon"><?= icon($c[0] === 'Enquiries' ? 'mail' : 'file') ?></span>
            <p><?= e($c[0]) ?></p><strong><?= e($c[1]) ?></strong>
        </a><?php endforeach; ?></div>
<div class="dashboard-grid">
    <section class="dashboard-card">
        <div class="card-heading">
            <h2>Recent content</h2><a href="entries.php">Manage all →</a>
        </div><?php if (!$recent): ?><p>No content yet. Add your first website item.</p><?php else: ?><table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody><?php foreach ($recent as $r): ?><tr>
                            <td><?= e($r['title']) ?></td>
                            <td><?= e(ucfirst($r['kind'])) ?></td>
                            <td><span class="status-badge <?= $r['published'] ? 'published' : 'draft' ?>"><?= $r['published'] ? 'Published' : 'Draft' ?></span></td>
                        </tr><?php endforeach; ?></tbody>
            </table><?php endif; ?>
    </section>
    <section class="dashboard-card">
        <div class="card-heading">
            <h2>Latest enquiries</h2><a href="messages.php">View all →</a>
        </div><?php if (!$enquiries): ?><div class="empty-state"><?= icon('mail') ?><h3>No enquiries yet</h3>
                <p>Contact form submissions will appear here.</p>
            </div><?php else: foreach ($enquiries as $r): ?><div class="enquiry-row"><span class="small-avatar"><?= e(strtoupper(substr($r['name'], 0, 1))) ?></span>
                    <div><strong><?= e($r['name']) ?></strong>
                        <p><?= e($r['created_at']) ?></p>
                    </div>
                </div><?php endforeach;
                endif; ?>
    </section>
</div>
<section class="dashboard-card getting-started">
    <h2>Make your website ready</h2>
    <p>Add your public phone and email in Company settings, review your service drafts, and publish the services your company currently offers.</p><a class="btn-company" href="settings.php">Update company settings</a>
</section><?php bottom(); ?>