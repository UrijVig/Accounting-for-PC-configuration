<div class="updater">
    <form action="/update" method="post">
    <h1><?= htmlspecialchars($tablename) ?></h1>
    <input type="hidden" name="tablename" value="<?= $tablename ?>">
    <?php foreach ($data as $key=>$val): ?>   
        <div class="form-group">
            <?php if ($key === "serial_number" || $key === "id"): ?>
                <p class="equipment_id"><?= htmlspecialchars($key) ?> : 
                <?= htmlspecialchars($val) ?></p>
                <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($val) ?>">
            <?php elseif ($key === "description"):?>
                <label for="description">Описание*</label>
                <textarea id="description" name="description" maxlength="255" placeholder="description maximum 255 characters"><?= 
                    htmlspecialchars($val ?? '') 
                ?></textarea>
            <?php else: ?>
                <label for="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($key) ?>*</label>
                <?php if (is_numeric($val)): ?>
                    <?php if (is_float($val)): ?>
                        <input type="number" id="<?= htmlspecialchars($key) ?>" name="<?= htmlspecialchars($key) ?>" 
                            min="1" step="0.1" required placeholder="<?= htmlspecialchars($key) ?>"
                            value="<?= htmlspecialchars($val) ?>">
                    <?php else: ?>
                        <input type="number" id="<?= htmlspecialchars($key) ?>" name="<?= htmlspecialchars($key) ?>" 
                            min="1" step="1" required placeholder="<?= htmlspecialchars($key) ?>"
                            value="<?= htmlspecialchars($val) ?>">
                    <?php endif; ?>
                <?php else: ?>
                    <input type="text" id="<?= htmlspecialchars($key) ?>" name="<?= htmlspecialchars($key) ?>" 
                        maxlength="50" required placeholder="<?= htmlspecialchars($key) ?>"
                        value="<?= htmlspecialchars($val) ?>">
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    <button type="submit" class="btn">Сохранить</button>
    </form>
</div>