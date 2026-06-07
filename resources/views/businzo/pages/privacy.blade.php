@extends('businzo.layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/5">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)] z-0"></div>
    <div class="max-w-4xl mx-auto px-6 lg:px-8 relative z-10">
        <div data-aos="fade-up">
            <h1 class="text-4xl md:text-5xl font-black font-['Outfit'] tracking-tight mb-6">Privacy Policy</h1>
            <p class="text-xl text-gray-400 font-light">Last updated: June 2026</p>
        </div>
    </div>
</div>

<section class="py-24 relative z-10" data-aos="fade-up" data-aos-delay="200">
    <div class="max-w-4xl mx-auto px-6 lg:px-8 prose prose-invert prose-lg">
        <p class="text-gray-400 leading-relaxed mb-8">
            At Businzo Technologies, we take your privacy seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our software development and IT services.
        </p>

        <h3 class="text-2xl font-bold font-['Outfit'] mt-12 mb-4 text-white">1. Information We Collect</h3>
        <p class="text-gray-400 leading-relaxed mb-6">
            We may collect information about you in a variety of ways. The information we may collect includes:
        </p>
        <ul class="list-disc pl-6 text-gray-400 mb-8 space-y-2">
            <li><strong>Personal Data:</strong> Personally identifiable information, such as your name, email address, and telephone number, that you voluntarily give to us when choosing to participate in various activities related to the Site, such as requesting estimates or consulting.</li>
            <li><strong>Derivative Data:</strong> Information our servers automatically collect when you access the Site, such as your IP address, your browser type, your operating system, and your access times.</li>
        </ul>

        <h3 class="text-2xl font-bold font-['Outfit'] mt-12 mb-4 text-white">2. Use of Your Information</h3>
        <p class="text-gray-400 leading-relaxed mb-6">
            Having accurate information about you permits us to provide you with a smooth, efficient, and customized experience. Specifically, we may use information collected about you via the Site to:
        </p>
        <ul class="list-disc pl-6 text-gray-400 mb-8 space-y-2">
            <li>Generate a personal profile about you to make future visits to the Site more personalized.</li>
            <li>Monitor and analyze usage and trends to improve your experience with the Site.</li>
            <li>Notify you of updates to our Site or Service offerings.</li>
            <li>Respond to product and customer service requests.</li>
        </ul>

        <h3 class="text-2xl font-bold font-['Outfit'] mt-12 mb-4 text-white">3. Security of Your Information</h3>
        <p class="text-gray-400 leading-relaxed mb-8">
            We use administrative, technical, and physical security measures to help protect your personal information. While we have taken reasonable steps to secure the personal information you provide to us, please be aware that despite our efforts, no security measures are perfect or impenetrable, and no method of data transmission can be guaranteed against any interception or other type of misuse.
        </p>

        <h3 class="text-2xl font-bold font-['Outfit'] mt-12 mb-4 text-white">4. Contact Us</h3>
        <p class="text-gray-400 leading-relaxed">
            If you have questions or comments about this Privacy Policy, please contact us at:<br>
            <a href="mailto:privacy@businzo.com" class="text-primary hover:text-blue-400 transition-colors">privacy@businzo.com</a>
        </p>
    </div>
</section>
@endsection
