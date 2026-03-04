<?php
// ============================================================
//  CONNEXION À LA BASE campus_it
//  Adaptez les 4 variables ci-dessous à votre environnement
// ============================================================
$host   = 'localhost';
$dbname = 'campus_it';
$user   = 'admin';
$pass   = 'Hub-78-';

$pdo = null;
// try MySQL first, otherwise fall back to file-based SQLite
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user, $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    // fallback
    $sqliteFile = __DIR__ . '/campus_it.sqlite';
    $pdo = new PDO('sqlite:' . $sqliteFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ensure schema exists
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS application (
            app_id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT NOT NULL
        );"
    );
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS ressource (
            res_id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom TEXT NOT NULL
        );"
    );
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS consommation (
            cons_id INTEGER PRIMARY KEY AUTOINCREMENT,
            app_id INTEGER,
            res_id INTEGER,
            mois TEXT,
            volume REAL
        );"
    );

    // seed minimal data if empty
    $cnt = $pdo->query('SELECT COUNT(*) FROM application')->fetchColumn();
    if ($cnt == 0) {
        $pdo->exec("INSERT INTO application (nom) VALUES
            ('Portail Étudiant'),
            ('Messagerie'),
            ('Parc Informatique'),
            ('Intranet'),
            ('Gestion Absences');");
        $pdo->exec("INSERT INTO ressource (nom) VALUES ('Stockage'),('Réseau');");
        // sample consommation for months through Feb 2026
        $pdo->exec("INSERT INTO consommation (app_id,res_id,mois,volume) VALUES
          (1,1,'2025-01-01',1000),(1,2,'2025-01-01',1200),
          (1,1,'2025-02-01',1050),(1,2,'2025-02-01',1250),
          (1,1,'2025-03-01',1100),(1,2,'2025-03-01',1300),
          (1,1,'2025-04-01',1150),(1,2,'2025-04-01',1350),
          (1,1,'2025-05-01',1200),(1,2,'2025-05-01',1400),
          (1,1,'2025-06-01',1250),(1,2,'2025-06-01',1450),
          (1,1,'2025-07-01',1280),(1,2,'2025-07-01',1480),
          (1,1,'2025-08-01',1300),(1,2,'2025-08-01',1500),
          (1,1,'2025-09-01',1350),(1,2,'2025-09-01',1550),
          (1,1,'2025-10-01',1400),(1,2,'2025-10-01',1600),
          (1,1,'2025-11-01',1450),(1,2,'2025-11-01',1650),
          (1,1,'2025-12-01',1500),(1,2,'2025-12-01',1700),
          (1,1,'2026-01-01',1550),(1,2,'2026-01-01',1750),
          (1,1,'2026-02-01',1600),(1,2,'2026-02-01',1800),
          (2,1,'2025-01-01',900),(2,2,'2025-01-01',1100),
          (2,1,'2025-02-01',920),(2,2,'2025-02-01',1120),
          (2,1,'2025-03-01',940),(2,2,'2025-03-01',1140),
          (2,1,'2025-04-01',960),(2,2,'2025-04-01',1160),
          (2,1,'2025-05-01',980),(2,2,'2025-05-01',1180),
          (2,1,'2025-06-01',1000),(2,2,'2025-06-01',1200),
          (2,1,'2025-07-01',1020),(2,2,'2025-07-01',1220),
          (2,1,'2025-08-01',1040),(2,2,'2025-08-01',1240),
          (2,1,'2025-09-01',1060),(2,2,'2025-09-01',1260),
          (2,1,'2025-10-01',1080),(2,2,'2025-10-01',1280),
          (2,1,'2025-11-01',1100),(2,2,'2025-11-01',1300),
          (2,1,'2025-12-01',1120),(2,2,'2025-12-01',1320),
          (2,1,'2026-01-01',1140),(2,2,'2026-01-01',1340),
          (2,1,'2026-02-01',1160),(2,2,'2026-02-01',1360),
          (3,1,'2025-01-01',850),(3,2,'2025-01-01',900),
          (3,1,'2025-02-01',870),(3,2,'2025-02-01',920),
          (3,1,'2025-03-01',890),(3,2,'2025-03-01',940),
          (3,1,'2025-04-01',910),(3,2,'2025-04-01',960),
          (3,1,'2025-05-01',930),(3,2,'2025-05-01',980),
          (3,1,'2025-06-01',950),(3,2,'2025-06-01',1000),
          (3,1,'2025-07-01',960),(3,2,'2025-07-01',1010),
          (3,1,'2025-08-01',970),(3,2,'2025-08-01',1020),
          (3,1,'2025-09-01',980),(3,2,'2025-09-01',1030),
          (3,1,'2025-10-01',990),(3,2,'2025-10-01',1040),
          (3,1,'2025-11-01',1000),(3,2,'2025-11-01',1050),
          (3,1,'2025-12-01',1010),(3,2,'2025-12-01',1060),
          (3,1,'2026-01-01',1020),(3,2,'2026-01-01',1070),
          (3,1,'2026-02-01',1030),(3,2,'2026-02-01',1080),
          (4,1,'2025-01-01',650),(4,2,'2025-01-01',750),
          (4,1,'2025-02-01',670),(4,2,'2025-02-01',770),
          (4,1,'2025-03-01',690),(4,2,'2025-03-01',790),
          (4,1,'2025-04-01',710),(4,2,'2025-04-01',810),
          (4,1,'2025-05-01',730),(4,2,'2025-05-01',830),
          (4,1,'2025-06-01',750),(4,2,'2025-06-01',850),
          (4,1,'2025-07-01',740),(4,2,'2025-07-01',840),
          (4,1,'2025-08-01',720),(4,2,'2025-08-01',820),
          (4,1,'2025-09-01',700),(4,2,'2025-09-01',800),
          (4,1,'2025-10-01',680),(4,2,'2025-10-01',780),
          (4,1,'2025-11-01',660),(4,2,'2025-11-01',760),
          (4,1,'2025-12-01',640),(4,2,'2025-12-01',740),
          (4,1,'2026-01-01',630),(4,2,'2026-01-01',730),
          (4,1,'2026-02-01',620),(4,2,'2026-02-01',720),
          (5,1,'2025-01-01',600),(5,2,'2025-01-01',700),
          (5,1,'2025-02-01',620),(5,2,'2025-02-01',720),
          (5,1,'2025-03-01',640),(5,2,'2025-03-01',740),
          (5,1,'2025-04-01',660),(5,2,'2025-04-01',760),
          (5,1,'2025-05-01',680),(5,2,'2025-05-01',780),
          (5,1,'2025-06-01',700),(5,2,'2025-06-01',800),
          (5,1,'2025-07-01',710),(5,2,'2025-07-01',810),
          (5,1,'2025-08-01',720),(5,2,'2025-08-01',820),
          (5,1,'2025-09-01',730),(5,2,'2025-09-01',830),
          (5,1,'2025-10-01',740),(5,2,'2025-10-01',840),
          (5,1,'2025-11-01',750),(5,2,'2025-11-01',850),
          (5,1,'2025-12-01',760),(5,2,'2025-12-01',860),
          (5,1,'2026-01-01',770),(5,2,'2026-01-01',870),
          (5,1,'2026-02-01',780),(5,2,'2026-02-01',880);");
    }
}

// ============================================================
//  REQUÊTE 1 — Top 5 applications les plus consommatrices
//  Tables : consommation JOIN application
//  Clé de jointure : consommation.app_id = application.app_id
//  Agrégation : SUM(volume) GROUP BY application
// ============================================================
$sql_top5 = "
    SELECT   a.nom                      AS nom_app,
             ROUND(SUM(c.volume), 2)    AS total_volume,
             COUNT(DISTINCT c.mois)     AS nb_mois
    FROM     consommation c
    JOIN     application  a ON a.app_id = c.app_id
    GROUP BY a.app_id, a.nom
    ORDER BY total_volume DESC
    LIMIT    5
";
$top5    = $pdo->query($sql_top5)->fetchAll(PDO::FETCH_ASSOC);
$max_vol = !empty($top5) ? $top5[0]['total_volume'] : 1;

// ============================================================
//  REQUÊTE 2 — Évolution mensuelle jan–juin 2025
//  Table  : consommation
//  Filtre : mois BETWEEN '2025-01-01' AND '2025-06-01'
// ============================================================
$sql_evo = "
    SELECT   mois                           AS mois_raw,
             ROUND(SUM(volume), 2)          AS total_volume
    FROM     consommation
    WHERE    mois BETWEEN '2025-01-01' AND '2025-06-01'
    GROUP BY mois
    ORDER BY mois ASC
";
$evolution = $pdo->query($sql_evo)->fetchAll(PDO::FETCH_ASSOC);
// generate labels for any driver
foreach ($evolution as &$row) {
    $date = strtotime($row['mois_raw']);
    $row['mois_label'] = $date ? strftime('%B %Y', $date) : $row['mois_raw'];
}
unset($row);
$max_evo   = !empty($evolution) ? max(array_column($evolution, 'total_volume')) : 1;

// Calcul de la variation mois/mois en PHP (pas de LAG() en MySQL 5.7 ou SQLite)
foreach ($evolution as $i => &$row) {
    $row['variation'] = ($i === 0)
        ? null
        : round(($row['total_volume'] - $evolution[$i-1]['total_volume'])
                / $evolution[$i-1]['total_volume'] * 100, 1);
}
unset($row);

// ============================================================
//  REQUÊTE 3 — Comparaison Stockage vs Réseau, mois par mois
//  Tables : consommation JOIN ressource
//  Clé de jointure : consommation.res_id = ressource.res_id
//  Pivot conditionnel : CASE WHEN r.nom = 'Stockage' / 'Réseau'
// ============================================================
$sql_comp = "
    SELECT   c.mois                                                                AS mois_raw,
             ROUND(SUM(CASE WHEN r.nom = 'Stockage' THEN c.volume ELSE 0 END), 2)  AS stockage,
             ROUND(SUM(CASE WHEN r.nom = 'Réseau'   THEN c.volume ELSE 0 END), 2)  AS reseau
    FROM     consommation c
    JOIN     ressource    r ON r.res_id = c.res_id
    GROUP BY c.mois
    ORDER BY c.mois ASC
";
$comparaison = $pdo->query($sql_comp)->fetchAll(PDO::FETCH_ASSOC);
// add labels
foreach ($comparaison as &$row) {
    $date = strtotime($row['mois_raw']);
    $row['mois_label'] = $date ? strftime('%B %Y', $date) : $row['mois_raw'];
}
unset($row);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Campus IT — Tableau de bord</title>
  <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@700;800&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    :root {
      --bg:      #0d0f14;
      --surface: #161a23;
      --border:  #252a37;
      --accent1: #00e5a0;
      --accent2: #ff6b35;
      --accent3: #5b8eff;
      --text:    #e8eaf0;
      --muted:   #6b7280;
      --mono:    'DM Mono', monospace;
      --display: 'Syne', sans-serif;
    }
    body { background:var(--bg); color:var(--text); font-family:var(--mono); min-height:100vh; padding-bottom:60px; }

    /* ── HEADER ── */
    header { padding:36px 48px 28px; border-bottom:1px solid var(--border); display:flex; align-items:flex-end; gap:20px; flex-wrap:wrap; }
    .badge { font-size:10px; letter-spacing:.2em; color:var(--accent1); text-transform:uppercase; background:rgba(0,229,160,.08); border:1px solid rgba(0,229,160,.25); padding:4px 10px; border-radius:2px; margin-bottom:6px; display:inline-block; }
    header h1 { font-family:var(--display); font-size:clamp(20px,3vw,32px); font-weight:800; letter-spacing:-.02em; }
    header h1 span { color:var(--accent1); }
    .header-right { margin-left:auto; text-align:right; font-size:11px; color:var(--muted); line-height:1.8; }
    .db-info { font-size:10px; color:var(--accent3); margin-top:4px; }

    /* ── TABS ── */
    .tab-bar { display:flex; padding:0 48px; border-bottom:1px solid var(--border); background:var(--bg); position:sticky; top:0; z-index:10; overflow-x:auto; }
    .tab-btn { background:none; border:none; border-bottom:3px solid transparent; color:var(--muted); font-family:var(--mono); font-size:12px; letter-spacing:.1em; text-transform:uppercase; padding:18px 24px; cursor:pointer; transition:color .2s,border-color .2s; white-space:nowrap; }
    .tab-btn:hover { color:var(--text); }
    .tab-btn.active { color:var(--accent1); border-bottom-color:var(--accent1); }
    .tab-num { display:inline-block; width:18px; height:18px; border-radius:50%; background:var(--border); text-align:center; line-height:18px; font-size:10px; margin-right:8px; color:var(--muted); }
    .tab-btn.active .tab-num { background:var(--accent1); color:#000; }

    /* ── CONTENT ── */
    .tab-content { display:none; padding:48px; animation:fadeUp .35s ease; }
    .tab-content.active { display:block; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
    .section-title { font-family:var(--display); font-size:20px; font-weight:700; margin-bottom:6px; }
    .section-sub { font-size:11px; color:var(--muted); margin-bottom:24px; letter-spacing:.05em; }
    code { background:rgba(91,142,255,.12); color:var(--accent3); padding:1px 6px; border-radius:3px; font-size:11px; }

    /* ── BLOC SQL ── */
    .sql-label { font-size:10px; letter-spacing:.15em; text-transform:uppercase; color:var(--accent3); margin-bottom:6px; margin-top:32px; }
    .sql-block { background:#08090d; border:1px solid var(--border); border-left:3px solid var(--accent3); border-radius:4px; padding:16px 20px; font-size:11.5px; color:#a5b4fc; margin-bottom:32px; line-height:1.9; white-space:pre; overflow-x:auto; }
    .kw  { color:#f472b6; font-weight:500; }
    .fn  { color:var(--accent1); }
    .str { color:#facc15; }
    .cm  { color:var(--muted); font-style:italic; }

    /* ── TOP 5 ── */
    .top5-grid { display:flex; flex-direction:column; gap:12px; max-width:680px; }
    .app-row { display:grid; grid-template-columns:28px 1fr auto; align-items:center; gap:16px; background:var(--surface); border:1px solid var(--border); border-radius:6px; padding:16px 20px; transition:border-color .2s; }
    .app-row:hover { border-color:var(--accent1); }
    .rank { font-family:var(--display); font-size:22px; font-weight:800; color:var(--border); }
    .app-row:nth-child(1) .rank { color:var(--accent1); }
    .app-row:nth-child(2) .rank { color:var(--accent3); }
    .app-row:nth-child(3) .rank { color:var(--accent2); }
    .app-row:nth-child(4) .rank { color:#a78bfa; }
    .app-row:nth-child(5) .rank { color:#facc15; }
    .app-info { display:flex; flex-direction:column; gap:6px; }
    .app-name { font-size:14px; font-weight:500; }
    .app-meta { font-size:10px; color:var(--muted); }
    .bar-wrap { width:100%; height:4px; background:var(--border); border-radius:2px; overflow:hidden; }
    .bar-fill { height:100%; border-radius:2px; }
    .app-row:nth-child(1) .bar-fill { background:var(--accent1); }
    .app-row:nth-child(2) .bar-fill { background:var(--accent3); }
    .app-row:nth-child(3) .bar-fill { background:var(--accent2); }
    .app-row:nth-child(4) .bar-fill { background:#a78bfa; }
    .app-row:nth-child(5) .bar-fill { background:#facc15; }
    .app-volume { text-align:right; font-size:18px; font-weight:500; white-space:nowrap; }
    .app-volume span { display:block; font-size:10px; color:var(--muted); letter-spacing:.1em; }

    /* ── TABLES ── */
    .data-table { width:100%; max-width:700px; border-collapse:collapse; font-size:13px; }
    .data-table thead tr { border-bottom:1px solid var(--accent1); }
    .data-table thead th { text-align:left; font-size:10px; letter-spacing:.15em; text-transform:uppercase; color:var(--accent1); padding:10px 16px; font-weight:500; }
    .data-table tbody tr { border-bottom:1px solid var(--border); transition:background .15s; }
    .data-table tbody tr:hover { background:var(--surface); }
    .data-table tbody td { padding:14px 16px; }
    .num  { font-variant-numeric:tabular-nums; text-align:right; color:var(--accent1); }
    .num2 { font-variant-numeric:tabular-nums; text-align:right; color:var(--accent3); }
    .evo-bar { display:inline-block; height:8px; background:var(--accent1); border-radius:2px; vertical-align:middle; margin-left:10px; opacity:.6; }
    .delta { display:inline-block; font-size:10px; padding:2px 8px; border-radius:20px; }
    .delta.pos { background:rgba(0,229,160,.12); color:var(--accent1); }
    .delta.neg { background:rgba(255,107,53,.12); color:var(--accent2); }
    .legend { display:flex; gap:24px; margin-bottom:20px; font-size:11px; color:var(--muted); }
    .legend-dot { display:inline-block; width:10px; height:10px; border-radius:2px; margin-right:6px; vertical-align:middle; }
    .empty { color:var(--muted); font-size:13px; padding:20px 0; }
  </style>
</head>
<body>

<header>
  <div>
    <div class="badge">Campus IT · Monitoring</div>
    <h1>Tableau de bord <span>Infrastructure</span></h1>
    <div class="db-info">Base : <?= htmlspecialchars($dbname) ?> · <?= htmlspecialchars($host) ?></div>
  </div>
  <div class="header-right">
    <?php
      $range = $pdo->query("SELECT MIN(mois), MAX(mois), COUNT(*) FROM consommation")->fetch();
      echo htmlspecialchars($range[0]) . ' → ' . htmlspecialchars($range[1]) . '<br>';
      echo number_format($range[2]) . ' enregistrements chargés';
    ?>
  </div>
</header>

<nav class="tab-bar">
  <button class="tab-btn active" onclick="openTab(event,'tab1')"><span class="tab-num">1</span>Top Consommateurs</button>
  <button class="tab-btn"        onclick="openTab(event,'tab2')"><span class="tab-num">2</span>Évolution Mensuelle</button>
  <button class="tab-btn"        onclick="openTab(event,'tab3')"><span class="tab-num">3</span>Comparaison Ressources</button>
</nav>


<!-- ═══════════════════════════════════════════════════
     ONGLET 1 — Top 5 applications
     SQL : consommation JOIN application
           GROUP BY app_id → SUM(volume) → LIMIT 5
════════════════════════════════════════════════════ -->
<div id="tab1" class="tab-content active">
  <div class="section-title">Top 5 — Applications les plus consommatrices</div>
  <div class="section-sub">
    Jointure <code>consommation</code> ↔ <code>application</code> ·
    <code>SUM(volume)</code> toutes ressources · tous mois
  </div>

  <div class="sql-label">↳ Requête SQL exécutée sur campus_it</div>
  <pre class="sql-block"><span class="cm">-- Jointure consommation ↔ application via app_id</span>
<span class="cm">-- Somme de tous les volumes par application, toutes ressources et mois confondus</span>
<span class="kw">SELECT</span>   a.nom                      <span class="kw">AS</span> nom_app,
         <span class="fn">ROUND</span>(<span class="fn">SUM</span>(c.volume), 2)    <span class="kw">AS</span> total_volume,
         <span class="fn">COUNT</span>(<span class="kw">DISTINCT</span> c.mois)     <span class="kw">AS</span> nb_mois
<span class="kw">FROM</span>     consommation c
<span class="kw">JOIN</span>     application  a  <span class="kw">ON</span>  a.app_id = c.app_id
<span class="kw">GROUP BY</span> a.app_id, a.nom
<span class="kw">ORDER BY</span> total_volume <span class="kw">DESC</span>
<span class="kw">LIMIT</span>    5</pre>

  <?php if (empty($top5)): ?>
    <p class="empty">Aucune donnée retournée par la requête.</p>
  <?php else: ?>
  <div class="top5-grid">
    <?php foreach ($top5 as $i => $row):
      $pct = round($row['total_volume'] / $max_vol * 100, 1);
    ?>
    <div class="app-row">
      <div class="rank"><?= $i + 1 ?></div>
      <div class="app-info">
        <div class="app-name"><?= htmlspecialchars($row['nom_app']) ?></div>
        <div class="app-meta"><?= (int)$row['nb_mois'] ?> mois · <?= $pct ?> % du max</div>
        <div class="bar-wrap">
          <div class="bar-fill" style="width:<?= $pct ?>%"></div>
        </div>
      </div>
      <div class="app-volume">
        <?= number_format($row['total_volume'], 2, ',', ' ') ?>
        <span>unités cumulées</span>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>


<!-- ═══════════════════════════════════════════════════
     ONGLET 2 — Évolution mensuelle jan–juin 2025
     SQL : consommation WHERE mois BETWEEN ...
           GROUP BY mois → SUM(volume)
════════════════════════════════════════════════════ -->
<div id="tab2" class="tab-content">
  <div class="section-title">Évolution mensuelle — Consommation totale campus</div>
  <div class="section-sub">
    Table <code>consommation</code> ·
    Filtre <code>WHERE mois BETWEEN '2025-01-01' AND '2025-06-01'</code> ·
    Variation calculée en PHP
  </div>

  <div class="sql-label">↳ Requête SQL exécutée sur campus_it</div>
  <pre class="sql-block"><span class="cm">-- Agrégation mensuelle, filtrée sur jan–juin 2025</span>
<span class="cm">-- Toutes applications et toutes ressources confondues</span>
<span class="kw">SELECT</span>   mois,
         <span class="fn">DATE_FORMAT</span>(mois, <span class="str">'%M %Y'</span>)   <span class="kw">AS</span> mois_label,
         <span class="fn">ROUND</span>(<span class="fn">SUM</span>(volume), 2)        <span class="kw">AS</span> total_volume
<span class="kw">FROM</span>     consommation
<span class="kw">WHERE</span>    mois <span class="kw">BETWEEN</span> <span class="str">'2025-01-01'</span> <span class="kw">AND</span> <span class="str">'2025-06-01'</span>
<span class="kw">GROUP BY</span> mois
<span class="kw">ORDER BY</span> mois <span class="kw">ASC</span></pre>

  <?php if (empty($evolution)): ?>
    <p class="empty">Aucune donnée retournée par la requête.</p>
  <?php else: ?>
  <table class="data-table">
    <thead>
      <tr>
        <th>Mois</th>
        <th style="text-align:right">Volume total</th>
        <th>Tendance</th>
        <th style="text-align:right">Variation M/M</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($evolution as $row):
      $bar_w = round($row['total_volume'] / $max_evo * 120);
    ?>
      <tr>
        <td><?= htmlspecialchars($row['mois_label']) ?></td>
        <td class="num"><?= number_format($row['total_volume'], 2, ',', ' ') ?></td>
        <td><span class="evo-bar" style="width:<?= $bar_w ?>px"></span></td>
        <td style="text-align:right">
          <?php if ($row['variation'] === null): ?>
            <span style="color:var(--muted);font-size:11px">—</span>
          <?php else:
            $sign = $row['variation'] >= 0 ? '+' : '';
            $cls  = $row['variation'] >= 0 ? 'pos' : 'neg';
          ?>
            <span class="delta <?= $cls ?>"><?= $sign.$row['variation'] ?> %</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>


<!-- ═══════════════════════════════════════════════════
     ONGLET 3 — Comparaison Stockage vs Réseau
     SQL : consommation JOIN ressource via res_id
           Pivot CASE WHEN → une colonne par ressource
════════════════════════════════════════════════════ -->
<div id="tab3" class="tab-content">
  <div class="section-title">Comparaison Stockage vs Réseau</div>
  <div class="section-sub">
    Jointure <code>consommation</code> ↔ <code>ressource</code> ·
    Pivot conditionnel <code>CASE WHEN r.nom = '...'</code> · tous mois disponibles
  </div>

  <div class="sql-label">↳ Requête SQL exécutée sur campus_it</div>
  <pre class="sql-block"><span class="cm">-- Jointure consommation ↔ ressource via res_id</span>
<span class="cm">-- Pivot : une colonne Stockage et une colonne Réseau par mois</span>
<span class="kw">SELECT</span>   c.mois,
         <span class="fn">DATE_FORMAT</span>(c.mois, <span class="str">'%M %Y'</span>)                                           <span class="kw">AS</span> mois_label,
         <span class="fn">ROUND</span>(<span class="fn">SUM</span>(<span class="kw">CASE WHEN</span> r.nom = <span class="str">'Stockage'</span> <span class="kw">THEN</span> c.volume <span class="kw">ELSE</span> 0 <span class="kw">END</span>), 2)   <span class="kw">AS</span> stockage,
         <span class="fn">ROUND</span>(<span class="fn">SUM</span>(<span class="kw">CASE WHEN</span> r.nom = <span class="str">'Réseau'</span>   <span class="kw">THEN</span> c.volume <span class="kw">ELSE</span> 0 <span class="kw">END</span>), 2)   <span class="kw">AS</span> reseau
<span class="kw">FROM</span>     consommation c
<span class="kw">JOIN</span>     ressource    r  <span class="kw">ON</span>  r.res_id = c.res_id
<span class="kw">GROUP BY</span> c.mois
<span class="kw">ORDER BY</span> c.mois <span class="kw">ASC</span></pre>

  <div class="legend">
    <span><span class="legend-dot" style="background:var(--accent1)"></span>Stockage (Go)</span>
    <span><span class="legend-dot" style="background:var(--accent3)"></span>Réseau (Go)</span>
  </div>

  <?php if (empty($comparaison)): ?>
    <p class="empty">Aucune donnée retournée par la requête.</p>
  <?php else: ?>
  <table class="data-table">
    <thead>
      <tr>
        <th>Mois</th>
        <th style="text-align:right">Stockage (Go)</th>
        <th style="text-align:right">Réseau (Go)</th>
        <th style="text-align:right">Écart (Go)</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($comparaison as $row):
      $ecart = round($row['stockage'] - $row['reseau'], 2);
      $sign  = $ecart >= 0 ? '+' : '';
      $cls   = $ecart >= 0 ? 'pos' : 'neg';
    ?>
      <tr>
        <td><?= htmlspecialchars($row['mois_label']) ?></td>
        <td class="num"><?= number_format($row['stockage'], 2, ',', ' ') ?></td>
        <td class="num2"><?= number_format($row['reseau'],  2, ',', ' ') ?></td>
        <td style="text-align:right">
          <span class="delta <?= $cls ?>"><?= $sign.number_format($ecart, 2, ',', ' ') ?></span>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</div>


<script>
  function openTab(event, id) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById(id).classList.add('active');
    event.currentTarget.classList.add('active');
  }
</script>

</body>
</html>
