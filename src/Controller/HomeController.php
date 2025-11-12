<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function __invoke(): Response
    {
        $html = <<<HTML
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Civil Registry API — Simulation</title>
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                color-scheme: light;
                --background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                --surface: #ffffff;
                --surface-muted: #f8fafc;
                --text-primary: #0f172a;
                --text-secondary: #334155;
                --text-muted: #475569;
                --border: rgba(15, 23, 42, 0.08);
                --border-muted: rgba(148, 163, 184, 0.25);
                --accent: #0ea5e9;
                --accent-strong: #0284c7;
                --accent-shadow: rgba(56, 189, 248, 0.35);
                --pill-bg: rgba(14, 165, 233, 0.12);
                --pill-border: rgba(14, 165, 233, 0.28);
                --shadow: 0 18px 48px rgba(15, 23, 42, 0.05);
                --feature-1: linear-gradient(140deg, #dbeafe 0%, #bfdbfe 100%);
                --feature-2: linear-gradient(140deg, #fce7f3 0%, #fbcfe8 100%);
                --feature-3: linear-gradient(140deg, #dcfce7 0%, #bbf7d0 100%);
                --feature-4: linear-gradient(140deg, #fef3c7 0%, #fde68a 100%);
                --code-bg: linear-gradient(135deg, rgba(14, 165, 233, 0.12) 0%, rgba(14, 165, 233, 0.05) 100%);
                --code-border: rgba(14, 165, 233, 0.3);
                --code-text: #0f172a;
                --code-muted: rgba(15, 23, 42, 0.7);
                --code-key: #0284c7;
                --code-string: #10b981;
                --code-number: #f59e0b;
                --code-punctuation: #0f172a;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                background: var(--background);
                color: var(--text-secondary);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: clamp(1.5rem, 6vw, 3rem);
            }

            .container {
                width: min(1040px, 100%);
                background-color: var(--surface);
                border-radius: 24px;
                border: 1px solid var(--border);
                padding: clamp(0.7rem, 3vw, 2.2rem);
                box-shadow: var(--shadow);
            }

            header span {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.16rem;
                font-weight: 700;
                color: var(--accent-strong);
            }

            h1 {
                margin-top: 1rem;
                font-size: clamp(2.2rem, 5vw, 3rem);
                color: #0f172a;
                line-height: 1.15;
            }

            p.lead {
                margin: 1rem 0 2.5rem;
                max-width: 52ch;
                line-height: 1.6;
                color: var(--text-secondary);
            }

            .cta-group {
                display: flex;
                flex-wrap: wrap;
                gap: 0.85rem;
            }

            a.button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.7rem 1.6rem;
                border-radius: 999px;
                font-weight: 600;
                text-decoration: none;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                font-size: 0.95rem;
            }

            a.button.primary {
                background: linear-gradient(135deg, var(--accent) 0%, var(--accent-strong) 100%);
                color: #f8fafc;
                box-shadow: 0 8px 20px rgba(14, 165, 233, 0.25);
            }

            a.button.secondary {
                color: var(--accent-strong);
                border: 1px solid rgba(14, 165, 233, 0.2);
                background: rgba(14, 165, 233, 0.12);
            }

            a.button:hover {
                transform: translateY(-2px);
            }

            section {
                margin-top: clamp(2rem, 5vw, 3.5rem);
                display: grid;
                gap: 1.5rem;
            }

            .pill {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.6rem 1.1rem;
                border-radius: 999px;
                background: var(--pill-bg);
                border: 1px solid var(--pill-border);
                color: var(--accent-strong);
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.1rem;
                width: fit-content;
                font-size: 0.85rem;
            }

            .grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 1.1rem;
            }

            .card {
                padding: 1.25rem;
                border-radius: 20px;
                background: var(--surface-muted);
                border: 1px solid rgba(15, 23, 42, 0.06);
                display: flex;
                flex-direction: column;
                gap: 0.6rem;
                color: var(--text-secondary);
                font-size: 0.95rem;
            }

            .card h3 {
                margin: 0;
                font-size: 1rem;
                color: var(--text-primary);
            }

            footer {
                margin-top: 1.75rem;
                border-top: 1px solid var(--border);
                padding-top: 1.25rem;
                font-size: 0.82rem;
                line-height: 1.6;
                color: rgba(51, 65, 85, 0.85);
            }

            footer strong {
                color: var(--text-primary);
            }
        </style>
    </head>
    <body>
        <main class="container">
            <header>
                <span>simulation api</span>
                <h1>Civil Registry API</h1>
                <p class="lead">
                    Une API REST bilingue (français / arabe) destinée aux tests et démonstrations.
                    Obtenez des profils citoyens fictifs conformes aux normes mauritaniennes pour vos prototypes de services numériques.
                </p>
                <div class="cta-group">
                    <a class="button primary" href="https://github.com/neo-tic/civil-registry/blob/main/docs/API.md" target="_blank" rel="noopener">
                        Consulter la documentation API
                    </a>
                    <a class="button secondary" href="https://neo-tic.com" target="_blank" rel="noopener">
                        Propulsé par NEOTIC
                    </a>
                </div>
            </header>

            <section aria-labelledby="features">
                <div class="pill" id="features">Fonctionnalités principales</div>
                <div class="grid">
                    <article class="card">
                        <h3>Dataset réaliste</h3>
                        <p>100 fiches citoyennes équilibrées avec des noms, adresses et répartitions démographiques représentatifs de la Mauritanie.</p>
                    </article>
                    <article class="card">
                        <h3>Bilingue &amp; localisé</h3>
                        <p>Chaque champ textuel est fourni en français et en arabe, avec la possibilité de choisir une langue ou les deux.</p>
                    </article>
                    <article class="card">
                        <h3>Réponses structurées</h3>
                        <p>Design API robuste : codes d’erreur normalisés, métadonnées et disclaimers inclus systématiquement.</p>
                    </article>
                    <article class="card">
                        <h3>Prêt pour l’intégration</h3>
                        <p>Base Symfony moderne, tests automatisés et fixtures déterministes pour reproduire facilement les scénarios.</p>
                    </article>
                </div>
            </section>

            <section aria-labelledby="endpoint">
                <div class="pill" id="endpoint">Point d’accès</div>
                <div class="card">
                    <h3>GET /api/v1/check-nni/{nni}</h3>
                    <p>
                        Effectuez une requête HTTP avec un NNI mauritanien à 10 chiffres et le paramètre optionnel <code>lang</code>
                        (<code>fr</code>, <code>ar</code>, <code>both</code>). La réponse contient les informations citoyennes simulées ainsi qu’un rappel de non-affiliation gouvernementale.
                    </p>
                    <div style="display:grid; gap:1rem;">
                        <div style="padding:0.9rem 1rem; border-radius:16px; background:#fff; border:1px solid rgba(15,23,42,0.08);">
                            <strong>Requête</strong>
                            <pre style="margin:0.6rem 0 0; font-size:0.9rem;">
<span style="color:#64748b;"># Récupération en français</span>
curl "<span style="color:#0284c7;">https://registry.neotic.dev/api/v1/check-nni/1200000000</span>?<span style="color:#0f172a;">lang</span>=<span style="color:#10b981;">fr</span>"

<span style="color:#64748b;"># Réponse bilingue</span>
curl "<span style="color:#0284c7;">https://registry.neotic.dev/api/v1/check-nni/1200000002</span>?<span style="color:#0f172a;">lang</span>=<span style="color:#10b981;">both</span>"
                            </pre>
                        </div>
                        <div style="padding:0.9rem 1rem; border-radius:16px; background:#fff; border:1px solid rgba(15,23,42,0.08);">
                            <strong>Réponse (fr)</strong>
                            <pre style="margin:0.6rem 0 0; font-size:0.9rem; white-space:pre-wrap;">
{
  "<span style="color:#0284c7;">data</span>": {
    "<span style="color:#0284c7;">nni</span>": "<span style="color:#10b981;">1200000000</span>",
    "<span style="color:#0284c7;">first_name</span>": "<span style="color:#10b981;">Sidi</span>",
    "<span style="color:#0284c7;">last_name</span>": "<span style="color:#10b981;">Ould Ahmed</span>",
    "<span style="color:#0284c7;">gender</span>": "<span style="color:#10b981;">Masculin</span>",
    "<span style="color:#0284c7;">date_of_birth</span>": "<span style="color:#10b981;">1990-04-01</span>",
    "<span style="color:#0284c7;">place_of_birth</span>": "<span style="color:#10b981;">Nouakchott</span>",
    "<span style="color:#0284c7;">marital_status</span>": "<span style="color:#10b981;">Marié(e)</span>",
    "<span style="color:#0284c7;">nationality</span>": "<span style="color:#10b981;">Mauritanienne</span>",
    "<span style="color:#0284c7;">address</span>": "<span style="color:#10b981;">Quartier Teyarett, Nouakchott, Mauritanie</span>"
  },
  "<span style="color:#0284c7;">meta</span>": {
    "<span style="color:#0284c7;">language</span>": "<span style="color:#10b981;">fr</span>",
    "<span style="color:#0284c7;">retrieved_at</span>": "<span style="color:#10b981;">2025-11-12T16:45:00+00:00</span>",
    "<span style="color:#0284c7;">source</span>": "<span style="color:#10b981;">Civil Registry API Simulation – Not an official government service</span>",
    "<span style="color:#0284c7;">disclaimer</span>": {
      "<span style="color:#0284c7;">fr</span>": "<span style="color:#10b981;">Données fictives fournies uniquement à des fins de test et de prototypage.</span>",
      "<span style="color:#0284c7;">ar</span>": "<span style="color:#10b981;">البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط.</span>"
    }
  }
}
                            </pre>
                        </div>
                        <div style="padding:0.9rem 1rem; border-radius:16px; background:#fff; border:1px solid rgba(15,23,42,0.08);">
                            <strong>Réponse (both)</strong>
                            <pre style="margin:0.6rem 0 0; font-size:0.9rem; white-space:pre-wrap;">
{
  "<span style="color:#0284c7;">data</span>": {
    "<span style="color:#0284c7;">nni</span>": "<span style="color:#10b981;">1200000002</span>",
    "<span style="color:#0284c7;">first_name</span>": {
      "<span style="color:#0284c7;">fr</span>": "<span style="color:#10b981;">Ahmed</span>",
      "<span style="color:#0284c7;">ar</span>": "<span style="color:#10b981;">أحمد</span>"
    },
    "<span style="color:#0284c7;">last_name</span>": {
      "<span style="color:#0284c7;">fr</span>": "<span style="color:#10b981;">Ould Cheikh</span>",
      "<span style="color:#0284c7;">ar</span>": "<span style="color:#10b981;">ولد الشيخ</span>"
    },
    "<span style="color:#0284c7;">gender</span>": {
      "<span style="color:#0284c7;">fr</span>": "<span style="color:#10b981;">Masculin</span>",
      "<span style="color:#0284c7;">ar</span>": "<span style="color:#10b981;">ذكر</span>"
    },
    "<span style="color:#0284c7;">date_of_birth</span>": "<span style="color:#10b981;">1985-02-14</span>",
    "<span style="color:#0284c7;">place_of_birth</span>": {
      "<span style="color:#0284c7;">fr</span>": "<span style="color:#10b981;">Kaédi</span>",
      "<span style="color:#0284c7;">ar</span>": "<span style="color:#10b981;">كيدي</span>"
    },
    "<span style="color:#0284c7;">marital_status</span>": {
      "<span style="color:#0284c7;">fr</span>": "<span style="color:#10b981;">Célibataire</span>",
      "<span style="color:#0284c7;">ar</span>": "<span style="color:#10b981;">أعزب/عزباء</span>"
    },
    "<span style="color:#0284c7;">nationality</span>": {
      "<span style="color:#0284c7;">fr</span>": "<span style="color:#10b981;">Mauritanienne</span>",
      "<span style="color:#0284c7;">ar</span>": "<span style="color:#10b981;">موريتانية</span>"
    },
    "<span style="color:#0284c7;">address</span>": {
      "<span style="color:#0284c7;">fr</span>": "<span style="color:#10b981;">Quartier Tevragh-Zeina, Kaédi, Mauritanie</span>",
      "<span style="color:#0284c7;">ar</span>": "<span style="color:#10b981;">حي تفرغ زينة، كيدي، موريتانيا</span>"
    }
  },
  "<span style="color:#0284c7;">meta</span>": {
    "<span style="color:#0284c7;">language</span>": "<span style="color:#10b981;">both</span>",
    "<span style="color:#0284c7;">retrieved_at</span>": "<span style="color:#10b981;">2025-11-12T16:45:00+00:00</span>",
    "<span style="color:#0284c7;">source</span>": "<span style="color:#10b981;">Civil Registry API Simulation – Not an official government service</span>",
    "<span style="color:#0284c7;">disclaimer</span>": {
      "<span style="color:#0284c7;">fr</span>": "<span style="color:#10b981;">Données fictives fournies uniquement à des fins de test et de prototypage.</span>",
      "<span style="color:#0284c7;">ar</span>": "<span style="color:#10b981;">البيانات الواردة وهمية ومخصصة للاختبار والنمذجة فقط.</span>"
    }
  }
}
                            </pre>
                        </div>
                    </div>
                </div>
            </section>

            <footer>
                <strong>Important :</strong> Les données retournées sont entièrement fictives et générées dans un but de test et de prototypage.
                Cette plateforme n’est affiliée à aucune administration publique.
            </footer>
        </main>
    </body>
</html>
HTML;

        return new Response($html);
    }
}

