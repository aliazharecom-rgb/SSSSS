<?php
/*
UMAR AUTH - Account Upgrade Helper
----------------------------------
Self-hosted instances ke liye: kisi account ko Developer/Seller role mein manually upgrade karne ke liye
WARNING: Production mein is file ko use karne ke baad DELETE kar dijiye ya password protect kar dijiye
*/

require_once __DIR__ . '/includes/misc/autoload.phtml';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>UMAR AUTH - Account Upgrade</title></head><body style='font-family:Arial;background:#09090d;color:#fff;padding:20px;'>";
echo "<h2 style='color:#4fea74;'>UMAR AUTH - Account Upgrade Tool</h2>";

if (isset($_POST['upgrade'])) {
    $username = misc\etc\sanitize($_POST['username']);
    $role = misc\etc\sanitize($_POST['role']);
    $duration_days = intval($_POST['duration_days']);

    if (!in_array($role, ['tester', 'developer', 'seller'])) {
        echo "<p style='color:#ff5a00;'>Invalid role! Use: tester, developer, or seller</p>";
    } else {
        $query = misc\mysql\query("SELECT username FROM accounts WHERE username = ?", [$username]);
        if ($query->num_rows === 0) {
            echo "<p style='color:#ff5a00;'>Account '$username' doesn't exist!</p>";
        } else {
            $expires = $duration_days > 0 ? (time() + ($duration_days * 86400)) : (time() + (36500 * 86400));
            misc\mysql\query("UPDATE accounts SET role = ?, expires = ? WHERE username = ?", [$role, $expires, $username]);
            echo "<p style='color:#1db233;'>SUCCESS: Upgraded '$username' to <b>$role</b> role, expires: " . date('Y-m-d H:i:s', $expires) . "</p>";
            echo "<p style='color:#aaa;'>Tip: Duration = 0 means lifetime (~100 years)</p>";
        }
    }
}
?>

<form method="post" style="margin-top:20px;max-width:500px;background:#0f0f17;padding:20px;border-radius:10px;">
    <div style="margin-bottom:15px;">
        <label style="display:block;margin-bottom:5px;">Username (of account to upgrade):</label>
        <input type="text" name="username" required style="width:100%;padding:8px;background:#09090d;border:1px solid #222;color:#fff;border-radius:5px;">
    </div>
    <div style="margin-bottom:15px;">
        <label style="display:block;margin-bottom:5px;">Role:</label>
        <select name="role" style="width:100%;padding:8px;background:#09090d;border:1px solid #222;color:#fff;border-radius:5px;">
            <option value="seller">Seller (Full Access - Recommended)</option>
            <option value="developer">Developer (Medium Access)</option>
            <option value="tester">Tester (Limited)</option>
        </select>
    </div>
    <div style="margin-bottom:15px;">
        <label style="display:block;margin-bottom:5px;">Duration (Days): <small style="color:#aaa;">0 = Lifetime</small></label>
        <input type="number" name="duration_days" value="365" min="0" style="width:100%;padding:8px;background:#09090d;border:1px solid #222;color:#fff;border-radius:5px;">
    </div>
    <button type="submit" name="upgrade" style="background:#1db233;color:#fff;border:none;padding:10px 20px;border-radius:5px;cursor:pointer;font-weight:bold;width:100%;">Upgrade Account</button>
</form>

<h3 style="margin-top:40px;color:#aaa;">Current Accounts:</h3>
<table border="1" style="border-collapse:collapse;background:#0f0f17;">
<tr style="background:#1a1a25;"><th style="padding:10px;">Username</th><th style="padding:10px;">Role</th><th style="padding:10px;">Expires</th></tr>
<?php
$result = misc\mysql\query("SELECT username, role, expires FROM accounts ORDER BY role, username");
while ($row = mysqli_fetch_assoc($result->result)) {
    $expires_text = $row['expires'] ? date('Y-m-d H:i:s', $row['expires']) : 'N/A';
    $role_color = match($row['role']) {
        'seller' => '#4fea74',
        'developer' => '#6acc1a',
        'tester' => '#aaa',
        default => '#fff'
    };
    echo "<tr><td style='padding:8px;'>{$row['username']}</td><td style='padding:8px;color:{$role_color};'>{$row['role']}</td><td style='padding:8px;'>{$expires_text}</td></tr>";
}
?>
</table>

<p style="margin-top:30px;color:#ff5a00;font-weight:bold;">⚠️ SECURITY WARNING: Delete this file (upgrade_account.php) after use, or move it to a password-protected folder!</p>
</body></html>
