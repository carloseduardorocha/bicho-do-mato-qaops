<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .footer {
        background-color: #04512d;
        padding: 40px 5% 0;
        margin-top: 0;
    }

    .footer-content {
        max-width: 1720px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 0;
    }

    .footer-section {
        display: flex;
        flex-direction: column;
    }

    .footer-title {
        color: #fff;
        font-size: 2.2rem;
        font-weight: 100;
        margin: 0;
        font-family: 'Nunito', sans-serif;
        line-height: 0.8;
    }

    .footer-title strong {
        font-weight: 900;
        display: block;
    }

    .contact-cards {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-top: auto;
    }

    .contact-card {
        background: #f5e8d1;
        border-radius: 20px;
        padding: 15px 25px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #5c3a21;
    }

    .contact-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
    }

    .contact-card i {
        font-size: 1.5rem;
        color: #2f5233;
        width: 30px;
        text-align: center;
    }

    .contact-card span {
        font-size: 1rem;
        font-weight: 600;
        color: #5c3a21;
    }

    .map-section {
        display: flex;
        flex-direction: column;
    }

    .map-wrapper {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        margin-top: 20px;
        height: 280px;
    }

    .map-wrapper iframe {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }

    .footer-bottom {
        background: #f3a632;
        padding: 20px 0;
        text-align: center;
        margin-top: 60px;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
    }

    .footer-bottom p {
        color: #5c3a21;
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        letter-spacing: 0.5px;
    }

    /* Responsive */
    @media (max-width: 1920px) {
        .footer-content {
            max-width: 1300px;
        }
    }

    @media (max-width: 1024px) {
        .footer-content {
            grid-template-columns: 1fr;
            gap: 50px;
        }

        .map-wrapper {
            height: 350px;
        }

        .contact-cards {
          margin-top: 2%;
        }
    }

    @media (max-width: 768px) {
        .footer {
            padding: 40px 5% 0;
        }

        .footer-title {
            font-size: 1.8rem;
        }

        .contact-card {
            padding: 12px 20px;
        }

        .contact-card i {
            font-size: 1.3rem;
        }

        .contact-card span {
            font-size: 0.9rem;
        }

        .map-wrapper {
            height: 300px;
        }

        .footer-bottom p {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .footer-title {
            font-size: 1.5rem;
        }

        .contact-card {
            padding: 10px 15px;
            gap: 10px;
        }

        .contact-card i {
            font-size: 1.2rem;
            width: 25px;
        }

        .contact-card span {
            font-size: 0.85rem;
        }

        .map-wrapper {
            height: 250px;
        }

        .footer-bottom {
            padding: 15px 5%;
        }

        .footer-bottom p {
            font-size: 0.75rem;
        }
    }
</style>

<footer class="footer">
    <div class="footer-content">
        <!-- Entre em contato conosco -->
        <div class="footer-section">
            <h3 class="footer-title"><i>Entre em</i> <strong>contato conosco:</strong></h3>
            
            <div class="contact-cards">
                <!-- Instagram -->
                <a href="https://www.instagram.com/ongbichodomato" target="_blank" class="contact-card">
                    <i class="fab fa-instagram"></i>
                    <span>@ongbichodomato</span>
                </a>

                <!-- Facebook -->
                <a href="https://www.facebook.com/bug.luiz.carlos.rodrigues" target="_blank" class="contact-card">
                    <i class="fab fa-facebook"></i>
                    <span>Luiz Carlos Rodrigues (Bug)</span>
                </a>

                <!-- WhatsApp -->
                <a href="https://wa.me/555596219405?text=Ol%C3%A1%21%20Acessei%20o%20site%20da%20ONG%20Bicho%20do%20Mato%20e%20gostaria%20de%20receber%20mais%20informa%C3%A7%C3%B5es%20sobre%20a%20institui%C3%A7%C3%A3o%20e%20como%20posso%20ajudar.%20Obrigado%21" target="_blank" class="contact-card">
                    <i class="fab fa-whatsapp"></i>
                    <span>(55) 9 9621-9405</span>
                </a>

                <!-- Email -->
                <a href="mailto:bug_alarme@hotmail.com" class="contact-card">
                    <i class="fas fa-envelope"></i>
                    <span>bug_alarme@hotmail.com</span>
                </a>
            </div>
        </div>

        <!-- Onde estamos -->
        <div class="footer-section map-section">
            <h3 class="footer-title"><i>Onde</i> <strong>estamos:</strong></h3>
            <div class="map-wrapper">
                <iframe 
                    src="https://www.google.com/maps?q=-27.332029206292926,-53.38300863558247&hl=pt-BR&z=16&amp;output=embed"
                    allowfullscreen="" 
                    loading="lazy"
                    title="Localização da ONG Bicho do Mato">
                </iframe>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <p>© 2025 ONG Bicho do Mato — Todos os direitos reservados.</p>
    </div>
</footer>