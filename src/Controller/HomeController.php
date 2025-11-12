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
                color-scheme: light dark;
                --bg: #0f172a;
                --bg-light: #f8fafc;
                --card: rgba(15, 23, 42, 0.65);
                --card-light: #ffffff;
                --accent: #38bdf8;
                --accent-dark: #0ea5e9;
                --muted: rgba(226, 232, 240, 0.75);
                --muted-dark: rgba(51, 65, 85, 0.8);
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                background: linear-gradient(135deg, var(--bg) 0%, #1e293b 100%);
                color: var(--muted);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: clamp(1.5rem, 5vw, 3rem);
            }

            .container {
                width: min(960px, 100%);
                background-color: var(--card);
                backdrop-filter: blur(16px);
                border-radius: 30px;
                border: 1px solid rgba(148, 163, 184, 0.15);
                padding: clamp(1rem, 4vw, 3rem);
                box-shadow: 0 40px 120px rgba(15, 23, 42, 0.45);
            }

            header span {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.16rem;
                font-weight: 700;
                color: var(--accent);
            }

            h1 {
                margin-top: 1rem;
                font-size: clamp(2.2rem, 5vw, 3rem);
                color: #f8fafc;
                line-height: 1.15;
            }

            p.lead {
                margin: 1rem 0 2.5rem;
                max-width: 52ch;
                line-height: 1.6;
            }

            .cta-group {
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
            }

            a.button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.85rem 1.8rem;
                border-radius: 999px;
                font-weight: 600;
                text-decoration: none;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            a.button.primary {
                background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
                color: #0f172a;
                box-shadow: 0 16px 40px rgba(14, 165, 233, 0.35);
            }

            a.button.secondary {
                color: var(--muted);
                border: 1px solid rgba(148, 163, 184, 0.35);
                background: transparent;
            }

            a.button:hover {
                transform: translateY(-2px);
            }

            section {
                margin-top: clamp(2.5rem, 6vw, 4rem);
                display: grid;
                gap: 1.75rem;
            }

            .pill {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem 1.2rem;
                border-radius: 999px;
                background: rgba(56, 189, 248, 0.12);
                color: var(--accent);
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.1rem;
                width: fit-content;
            }

            .grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 1.25rem;
            }

            .card {
                padding: 1.5rem;
                border-radius: 1.5rem;
                background: rgba(15, 23, 42, 0.45);
                border: 1px solid rgba(148, 163, 184, 0.12);
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
                color: #e2e8f0;
            }

            .card h3 {
                margin: 0;
                font-size: 1.05rem;
                color: #f1f5f9;
            }

            footer {
                margin-top: 2rem;
                border-top: 1px solid rgba(148, 163, 184, 0.15);
                padding-top: 1.5rem;
                font-size: 0.85rem;
                line-height: 1.6;
                color: rgba(226, 232, 240, 0.65);
            }

            footer strong {
                color: rgba(248, 250, 252, 0.9);
            }

            @media (prefers-color-scheme: light) {
                body {
                    background: var(--bg-light);
                    color: var(--muted-dark);
                }

                .container {
                    background: var(--card-light);
                    border: 1px solid rgba(15, 23, 42, 0.08);
                    box-shadow: 0 30px 80px rgba(15, 23, 42, 0.1);
                }

                .card {
                    background: #f8fafc;
                    border: 1px solid rgba(15, 23, 42, 0.06);
                    color: #1e293b;
                }

                h1 {
                    color: #0f172a;
                }

                p.lead {
                    color: #334155;
                }

                footer {
                    color: rgba(15, 23, 42, 0.65);
                }

                footer strong {
                    color: #0f172a;
                }
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

