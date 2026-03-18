<?php
session_start();
require_once '../../includes/auth.php';

requerirAdmin();
$sitioPublicoUrl = obtenerRutaProyecto('public/');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructivo de uso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../../img/LogoChaca.png" type="image/x-icon">
    <style>
        :root {
            --admin-fondo: #f5f7fb;
            --admin-superficie: #ffffff;
            --admin-texto: #0f172a;
            --admin-secundario: #64748b;
            --admin-borde: #dbe4ef;
            --admin-grad-a: #17324d;
            --admin-grad-b: #2a5d8f;
            --admin-acento: #2a5d8f;
        }

        body {
            background: var(--admin-fondo);
            color: var(--admin-texto);
        }
        .page-shell {
            max-width: 1140px;
            margin: 0 auto;
            padding: 24px 16px 48px;
        }
        .portada {
            background: linear-gradient(135deg, var(--admin-grad-a) 0%, var(--admin-grad-b) 100%);
            border-radius: 18px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
            margin-bottom: 24px;
            color: #fff;
        }
        .portada h1 {
            font-size: clamp(2rem, 4vw, 2.8rem);
            line-height: 1.1;
            margin-bottom: 12px;
        }
        .portada p {
            font-size: 1.05rem;
            max-width: 720px;
            margin-bottom: 0;
        }
        .top-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }
        .top-actions .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1rem;
            padding: 10px 18px;
            font-weight: 600;
            min-width: 190px;
        }
        .info-banner {
            background: #fff1f2;
            border: 2px solid #dc2626;
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 24px;
            color: #991b1b;
        }
        .info-banner strong {
            color: #7f1d1d;
        }
        .section-card {
            background: var(--admin-superficie);
            border: 0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            height: 100%;
        }
        .section-card h2 {
            color: var(--admin-grad-a);
            font-size: 1.45rem;
            margin-bottom: 16px;
        }
        .step-list {
            display: grid;
            gap: 14px;
        }
        .step {
            display: grid;
            grid-template-columns: 48px 1fr;
            gap: 12px;
            align-items: start;
            padding: 14px;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid var(--admin-borde);
        }
        .step-number {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            background: var(--admin-acento);
            color: #fff;
        }
        .step h3 {
            font-size: 1.1rem;
            margin-bottom: 8px;
        }
        .step p,
        .step li,
        .help-list li {
            font-size: 0.98rem;
            line-height: 1.6;
        }
        .help-list {
            margin: 0;
            padding-left: 20px;
        }
        .help-list li + li {
            margin-top: 10px;
        }
        .callout {
            margin-top: 18px;
            padding: 14px 16px;
            border-left: 4px solid var(--admin-acento);
            background: #eff6ff;
            border-radius: 12px;
            color: #1e3a5f;
        }
        .nota-final {
            margin-top: 24px;
            background: var(--admin-superficie);
            border: 1px solid var(--admin-borde);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        .nota-final h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--admin-grad-a);
        }

        @media (max-width: 768px){
            .portada,
            .section-card,
            .nota-final {
                padding: 22px;
            }

            .portada {
                text-align: center;
            }

            .step {
                grid-template-columns: 1fr;
            }

            .step-number {
                width: 48px;
                height: 48px;
                font-size: 1.2rem;
            }

            .top-actions {
                justify-content: center;
            }

            .top-actions .btn {
                width: 100%;
                max-width: 320px;
                margin: 0 auto;
            }
        }
    </style>
</head>
<body>
    <main class="page-shell">
        <section class="portada">
            <h1>Guía simple para usar el panel</h1>
            <p>Esta página está pensada para ayudarte a cambiar noticias y fotos. Seguí los pasos con calma. Si algo no sale como esperabas, siempre podés volver al panel y revisar otra vez.</p>
            <div class="top-actions">
                <a class="btn btn-light" href="panel.php">Volver al panel</a>
                <a class="btn btn-outline-light" href="<?php echo htmlspecialchars($sitioPublicoUrl); ?>">Ver página pública</a>
            </div>
        </section>

        <section class="info-banner">
            <strong>Consejo importante:</strong> después de guardar un cambio, revisa cómo quedó en la página pública. Si ves un error, podés volver a editarlo desde el panel.
        </section>

        <div class="row g-4">
            <div class="col-lg-6">
                <section class="section-card">
                    <h2>Cómo agregar una noticia</h2>
                    <div class="step-list">
                        <article class="step">
                            <div class="step-number">1</div>
                            <div>
                                <h3>Entra en Noticias</h3>
                                <p>En el panel, busca el bloque que dice Noticias y toca el boton <strong>Nueva noticia</strong>.</p>
                            </div>
                        </article>
                        <article class="step">
                            <div class="step-number">2</div>
                            <div>
                                <h3>Completa los campos</h3>
                                <p>Escribí un título claro, una fecha visible o subtítulo, una descripción corta y el texto completo de la noticia.</p>
                            </div>
                        </article>
                        <article class="step">
                            <div class="step-number">3</div>
                            <div>
                                <h3>Elegi una imagen</h3>
                                <p>Si queres mostrar una foto, toca el boton <strong>Seleccionar imagen</strong> y buscala en la computadora.</p>
                            </div>
                        </article>
                        <article class="step">
                            <div class="step-number">4</div>
                            <div>
                                <h3>Guarda</h3>
                                <p>Cuando termines, toca <strong>Guardar</strong>. La noticia nueva aparecera primero si tiene la fecha mas reciente.</p>
                            </div>
                        </article>
                    </div>
                </section>
            </div>

            <div class="col-lg-6">
                <section class="section-card">
                    <h2>Cómo editar o borrar una noticia</h2>
                    <div class="step-list">
                        <article class="step">
                            <div class="step-number">1</div>
                            <div>
                                <h3>Busca la noticia</h3>
                                <p>En el panel vas a ver las tarjetas con cada noticia publicada.</p>
                            </div>
                        </article>
                        <article class="step">
                            <div class="step-number">2</div>
                            <div>
                                <h3>Para cambiar algo</h3>
                                <p>Toca <strong>Editar</strong>, corregi el texto, la fecha visible o la imagen, y guarda otra vez.</p>
                            </div>
                        </article>
                        <article class="step">
                            <div class="step-number">3</div>
                            <div>
                                <h3>Para revisar cómo quedó</h3>
                                <p>Toca <strong>Ver publica</strong> y mira la noticia como la vera la gente.</p>
                            </div>
                        </article>
                        <article class="step">
                            <div class="step-number">4</div>
                            <div>
                                <h3>Para borrar</h3>
                                <p>Toca <strong>Eliminar</strong> solo si estas segura de que esa noticia ya no debe verse. El sistema te va a pedir confirmacion.</p>
                            </div>
                        </article>
                    </div>
                </section>
            </div>

            <div class="col-lg-6">
                <section class="section-card">
                    <h2>Cómo subir una foto a la galería</h2>
                    <div class="step-list">
                        <article class="step">
                            <div class="step-number">1</div>
                            <div>
                                <h3>Entra en Galería</h3>
                                <p>En el panel, anda al bloque de Galeria y toca <strong>Nueva foto</strong>.</p>
                            </div>
                        </article>
                        <article class="step">
                            <div class="step-number">2</div>
                            <div>
                                <h3>Escribí una descripción</h3>
                                <p>La descripción sirve para identificar la imagen. Usa una frase simple y corta.</p>
                            </div>
                        </article>
                        <article class="step">
                            <div class="step-number">3</div>
                            <div>
                                <h3>Selecciona la foto</h3>
                                <p>Elegí una imagen desde la computadora. Conviene usar fotos claras y bien encuadradas.</p>
                            </div>
                        </article>
                        <article class="step">
                            <div class="step-number">4</div>
                            <div>
                                <h3>Guarda y revisa</h3>
                                <p>Despues de guardar, entra a <strong>Ver galeria publica</strong> para confirmar que la foto se vea bien.</p>
                            </div>
                        </article>
                    </div>
                </section>
            </div>

            <div class="col-lg-6">
                <section class="section-card">
                    <h2>Si algo no sale bien</h2>
                    <ul class="help-list">
                        <li>Si una imagen no aparece, probá volver a subirla con otro nombre de archivo.</li>
                        <li>Si el texto quedo mal, toca <strong>Editar</strong> y corregilo. Despues guarda otra vez.</li>
                        <li>Si tocaste algo por error, no cierres todo enseguida: primero revisa la vista pública.</li>
                        <li>Si la pagina tarda, espera unos segundos antes de volver a tocar el boton.</li>
                        <li>Si seguis con dudas, usa siempre el boton <strong>Volver al panel</strong> para retomar desde el inicio.</li>
                    </ul>
                    <div class="callout">
                        Pensá el panel como una hoja de cambios: escribir, guardar y revisar.
                    </div>
                </section>
            </div>
        </div>

        <section class="nota-final">
            <h2>Resumen rápido</h2>
            <p class="mb-2">Para trabajar tranquila: entrar, escribir, guardar y revisar.</p>
            <p class="mb-0">Si querés confirmar cómo quedó, mira siempre la página pública antes de salir.</p>
        </section>
    </main>
</body>
</html>