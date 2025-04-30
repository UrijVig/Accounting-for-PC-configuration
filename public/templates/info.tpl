<?php if (!empty($system_units)): ?>
    <?php foreach ($system_units as $sdata): ?>
        <div class="system-unit">
            <h3>Computer: <?= htmlspecialchars($sdata['computer_name'] ?? 'N/A') ?></h3>
            <div class="info">
                <p class="info-item">Serial number: <?= htmlspecialchars($sdata['serial_number'] ?? 'N/A') ?></p>
                <p class="info-item">CPU: <?= htmlspecialchars($sdata['cpu'] ?? 'N/A') ?></p>
                <p class="info-item">RAM: <?= htmlspecialchars($sdata['ram_gb'] ?? 'N/A') ?> GB</p>
                <p class="info-item">Disk size: <?= htmlspecialchars($sdata['disk_size'] ?? 'N/A') ?> GB</p>
                <p class="info-item">Disk free: <?= htmlspecialchars($sdata['disk_free'] ?? 'N/A') ?> GB</p>
                <p class="info-item">GPU: <?= htmlspecialchars($sdata['gpu'] ?? 'N/A') ?></p>
                <p class="info-item">Location: <?= htmlspecialchars($sdata['location'] ?? 'N/A') ?></p>
                <p class="info-item">Description: <?= htmlspecialchars($sdata['description'] ?? 'N/A') ?></p>
                <form action="/info" method="post">
                <input type="hidden" name="delete" value="system_units">
                <input type="hidden" name="serial_number" value="<?= htmlspecialchars($sdata['serial_number'] ?? 'N/A') ?>">
                <input type="submit" value="DELETE!">
            </form>
            </div>        
            <div class="monitors">
                <?php foreach (($sdata['monitors'] ?? []) as $mdata): ?>
                    <div class="monitor">
                        <p>Model: <?= htmlspecialchars($mdata['model'] ?? 'N/A') ?></p>
                        <p>Serial: <?= htmlspecialchars($mdata['serial_number'] ?? 'N/A') ?></p>
                        <p>Diagonal: <?= htmlspecialchars($mdata['diagonal'] ?? 'N/A') ?>"</p>
                        <form action="/info" method="post">
                        <input type="hidden" name="delete" value="monitor">
                        <input type="hidden" name="serial_number" value="<?= htmlspecialchars($mdata['serial_number'] ?? 'N/A') ?>">
                        <input type="submit" value="DELETE!">
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="no-data">No system units found</p>
<?php endif; ?>