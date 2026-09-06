<?php
/*
 ================================================================
  UMAR AUTH 🔥  DIRECT ACCOUNT CREATOR
 --------------------------------------------------------------
  ✅ 2 Accounts Created Automatically:

  🟢 ACCOUNT #1 — DEVELOPER ROLE
     Username: CHILDUSER    Password: 1122
     Permissions: 50MB upload | unlimited vars | VPN block

  🔴 ACCOUNT #2 — SELLER ROLE (FULL ACCESS)
     Username: IRFAN        Password: 1122
     Permissions: 75MB upload | custom domains | seller API |
                  customer panel | chat channels
 ================================================================
  AFTER USE -> DELETE THIS FILE + upgrade_account.php !!!
*/

require_once __DIR__ . '/includes/misc/autoload.phtml';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>UMAR AUTH - Create Seller + Developer</title></head>
<body style='font-family:Arial;background:#09090d;color:#fff;padding:30px;margin:0;'>";

echo "<h1 style='color:#4fea74;font-size:28px;margin-bottom:5px;'>🏁 UMAR AUTH — DIRECT ACCOUNT SETUP</h1>";
echo "<p style='color:#aaa;margin-top:0;'>Click karte hi DEVELOPER + SELLER 2 accounts ban jayenge!</p>";

/* =========================
   🟢 DEVELOPER ACCOUNT
   ========================= */
$DEVELOPER = [
    'username' => 'CHILDUSER',
    'password' => '1122',
    'email'    => 'childuser@umarauth.local',
    'role'     => 'developer',
];

/* =========================
   🔴 SELLER ACCOUNT (FULL)
   ========================= */
$SELLER = [
    'username' => 'IRFAN',
    'password' => '1122',
    'email'    => 'irfan@umarauth.local',
    'role'     => 'seller',
];

$LIFETIME = time() + (100 * 365 * 24 * 60 * 60);

/* ---------- SHOW REFERENCE BOXES ---------- */
echo "<div style='display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:900px;margin-top:25px;'>";

/* 🟢 DEVELOPER BOX */
echo "<div style='border:3px solid #6acc1a;border-radius:14px;background:linear-gradient(145deg,#0f1b0a,#0a1508);padding:20px;'>
<div style='display:inline-block;background:#6acc1a;color:#000;font-weight:bold;padding:4px 14px;border-radius:20px;font-size:14px;'>🟢 DEVELOPER ROLE</div>
<h2 style='color:#6acc1a;font-size:30px;margin:10px 0 5px 0;'>CHILDUSER</h2>
<p style='font-size:16px;margin:5px 0;'>Password: <code style='background:#1a1a25;padding:3px 8px;border-radius:6px;color:#fff;'>1122</code></p>
<p style='font-size:13px;color:#aaa;margin-top:10px;'>→ 50MB Files | Unlimited Vars | VPN Block</p>
</div>";

/* 🔴 SELLER BOX */
echo "<div style='border:3px solid #4fea74;border-radius:14px;background:linear-gradient(145deg,#0c1c10,#081a0c);padding:20px;box-shadow:0 0 30px rgba(79,234,116,0.15);'>
<div style='display:inline-block;background:#4fea74;color:#000;font-weight:bold;padding:4px 14px;border-radius:20px;font-size:14px;'>🔴 SELLER ROLE ⭐ FULL ACCESS</div>
<h2 style='color:#4fea74;font-size:30px;margin:10px 0 5px 0;'>IRFAN</h2>
<p style='font-size:16px;margin:5px 0;'>Password: <code style='background:#1a1a25;padding:3px 8px;border-radius:6px;color:#fff;'>1122</code></p>
<p style='font-size:13px;color:#aaa;margin-top:10px;'>→ 75MB Files | Custom Domains | Seller API | Customer Panel | Chat Channels</p>
</div>";

echo "</div>";

/* ---------- PROCESS ACCOUNTS ---------- */
echo "<h2 style='color:#fff;margin-top:35px;'>⚡ RUNNING NOW...</h2>";
echo "<div style='max-width:900px;background:#0f0f17;padding:25px;border-radius:12px;border-left:6px solid #4fea74;'>";

$ALL_ACCOUNTS = [
    ['data' => $DEVELOPER, 'label' => '🟢 [DEVELOPER] CHILDUSER', 'badge_color' => '#6acc1a'],
    ['data' => $SELLER,    'label' => '🔴 [SELLER] IRFAN',        'badge_color' => '#4fea74'],
];

foreach ($ALL_ACCOUNTS as $PACK) {
    $acc        = $PACK['data'];
    $label      = $PACK['label'];
    $badge_color= $PACK['badge_color'];
    $username   = mysqli_real_escape_string(misc\mysql\connect(), $acc['username']);
    $email      = mysqli_real_escape_string(misc\mysql\connect(), strtolower($acc['email']));
    $email_sha1 = sha1($email);
    $pass_hash  = password_hash($acc['password'], PASSWORD_BCRYPT);
    $ownerid    = misc\etc\guidv4();
    $ip         = '127.0.0.1';

    echo "<h3 style='color:{$badge_color};margin:15px 0 5px 0;'>{$label}</h3>";

    $check = misc\mysql\query("SELECT username FROM accounts WHERE username = ?", [$username]);

    if ($check->num_rows > 0) {
        misc\mysql\query(
            "UPDATE accounts SET role = ?, expires = ?, password = ? WHERE username = ?",
            [$acc['role'], $LIFETIME, $pass_hash, $username]
        );
        echo "<p style='color:#ffcc00;margin:5px 0;'>⚠️  PEHLE SE HAI — Update ho gaya (role + password refresh)</p>";
    } else {
        misc\mysql\query(
            "INSERT INTO `accounts` (`username`, `email`, `password`, `ownerid`, `role`, `registrationip`, `expires`, `img`) VALUES (?, ?, ?, ?, ?, ?, ?, '')",
            [$username, $email_sha1, $pass_hash, $ownerid, $acc['role'], $ip, $LIFETIME]
        );
        echo "<p style='color:#4fea74;margin:5px 0;'>✅ DATABASE MEIN ADD HO GAYA!</p>";
    }
    echo "<p style='color:#aaa;margin:3px 0 15px 0;'>OwnerID: <code style='background:#1a1a25;padding:2px 6px;border-radius:4px;'>{$ownerid}</code> | Expiry: <b>Lifetime (~100 years)</b></p>";
}
echo "</div>";

/* ---------- SHOW ALL ACCOUNTS TABLE ---------- */
echo "<h3 style='margin-top:40px;color:#aaa;'>📋 DATABASE MEIN HAIN SARE ACCOUNTS:</h3>";
echo "<table border='1' style='border-collapse:collapse;background:#0f0f17;min-width:700px;font-size:15px;'>
<tr style='background:#1a1a25;'>
<th style='padding:12px;'>Username</th>
<th style='padding:12px;'>ROLE</th>
<th style='padding:12px;'>OwnerID</th>
<th style='padding:12px;'>Expires</th>
</tr>";

$result = misc\mysql\query("SELECT username, role, ownerid, expires FROM accounts ORDER BY role, username");
while ($row = mysqli_fetch_assoc($result->result)) {
    $expires_text = $row['expires'] ? date('Y-m-d H:i:s', $row['expires']) : 'N/A';
    $role_color = match($row['role']) {
        'seller'     => '#4fea74',
        'Reseller'   => '#b665ff',
        'Manager'    => '#ffb665',
        'developer'  => '#6acc1a',
        'tester'     => '#aaa',
        default      => '#fff'
    };
    $role_label = match($row['role']) {
        'seller'     => 'SELLER 🔥',
        'Reseller'   => 'RESELLER',
        'Manager'    => 'MANAGER',
        'developer'  => 'DEVELOPER',
        'tester'     => 'TESTER',
        default      => $row['role']
    };
    echo "<tr>
<td style='padding:10px;font-weight:bold;'>{$row['username']}</td>
<td style='padding:10px;color:{$role_color};font-weight:bold;'>{$role_label}</td>
<td style='padding:10px;font-size:12px;color:#aaa;'>{$row['ownerid']}</td>
<td style='padding:10px;'>{$expires_text}</td>
</tr>";
}
echo "</table>";

/* ---------- LOGIN LINKS ---------- */
echo "<div style='margin-top:30px;max-width:900px;display:grid;grid-template-columns:1fr 1fr;gap:15px;'>
<a href='login/' style='background:#6acc1a;color:#000;text-decoration:none;font-weight:bold;padding:15px;border-radius:10px;text-align:center;font-size:17px;'>→ Login as CHILDUSER (Developer)</a>
<a href='login/' style='background:#4fea74;color:#000;text-decoration:none;font-weight:bold;padding:15px;border-radius:10px;text-align:center;font-size:17px;'>→ Login as IRFAN (Seller — FULL ACCESS)</a>
</div>";

/* ---------- WARNING ---------- */
echo "<div style='margin-top:35px;padding:18px;background:#2a0e0e;border:1px solid #ff5a00;border-radius:12px;max-width:900px;'>
<p style='color:#ff5a00;font-weight:bold;margin:0 0 8px 0;font-size:16px;'>⚠️  JARURI — USE KE BAAD DELETE KARO IN FILES KO:</p>
<ul style='color:#ffccaa;margin:0;padding-left:20px;'>
<li><b>create_accounts.php</b> (yeh wali file)</li>
<li><b>upgrade_account.php</b> (manual role change tool)</li>
</ul>
<p style='color:#ffccaa;margin-top:10px;font-size:13px;'>Note: Password 1122 weak hai — isliye login page ka breach-check pehle hi disable kiya gaya hai. Production mein strong password use karo!</p>
</div>";

echo "</body></html>";
