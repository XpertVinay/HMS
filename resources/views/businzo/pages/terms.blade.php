@extends('businzo.layouts.app')

@section('title', 'Terms of Service')

@section('content')
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/5">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)] z-0"></div>
    <div class="max-w-4xl mx-auto px-6 lg:px-8 relative z-10">
        <div data-aos="fade-up">
            <h1 class="text-4xl md:text-5xl font-black font-['Outfit'] tracking-tight mb-6">Terms of Service</h1>
            <p class="text-xl text-muted font-light">Effective Date: June 2026</p>
        </div>
    </div>
</div>

<section class="py-24 relative z-10" data-aos="fade-up" data-aos-delay="200">
    <div class="max-w-4xl mx-auto px-6 lg:px-8 prose prose-invert prose-lg">
        <p class="text-muted leading-relaxed mb-8">
            Please read these Terms of Service ("Terms") carefully before using the Businzo Technologies website or engaging our software engineering services.
        </p>

        <h3 class="text-2xl font-bold font-['Outfit'] mt-12 mb-4 text-foreground">1. Agreement to Terms</h3>
        <p class="text-muted leading-relaxed mb-6">
            By accessing our website or utilizing our services, you agree to be bound by these Terms. If you disagree with any part of the terms, then you do not have permission to access the Service.
        </p>

        <h3 class="text-2xl font-bold font-['Outfit'] mt-12 mb-4 text-foreground">2. Intellectual Property</h3>
        <p class="text-muted leading-relaxed mb-6">
            The Service and its original content, features, and functionality are and will remain the exclusive property of Businzo Technologies and its licensors. The Service is protected by copyright, trademark, and other laws of both the local jurisdiction and foreign countries.
        </p>
        
        <h3 class="text-2xl font-bold font-['Outfit'] mt-12 mb-4 text-foreground">3. Services and Estimates</h3>
        <p class="text-muted leading-relaxed mb-6">
            Any estimates provided via our online calculator are for informational purposes only and do not constitute a binding contract. Final pricing and timelines will be determined only after a formal discovery phase and will be outlined in a separate Statement of Work (SOW).
        </p>

        <h3 class="text-2xl font-bold font-['Outfit'] mt-12 mb-4 text-foreground">4. Limitation of Liability</h3>
        <p class="text-muted leading-relaxed mb-8">
            In no event shall Businzo Technologies, nor its directors, employees, partners, agents, suppliers, or affiliates, be liable for any indirect, incidental, special, consequential or punitive damages, including without limitation, loss of profits, data, use, goodwill, or other intangible losses, resulting from your access to or use of or inability to access or use the Service.
        </p>

        <h3 class="text-2xl font-bold font-['Outfit'] mt-12 mb-4 text-foreground">5. Contact Us</h3>
        <p class="text-muted leading-relaxed">
            If you have any questions about these Terms, please contact us at:<br>
            <a href="mailto:legal@businzo.com" class="text-primary hover:text-primary-light transition-colors">legal@businzo.com</a>
        </p>
    </div>
</section>
@endsection
