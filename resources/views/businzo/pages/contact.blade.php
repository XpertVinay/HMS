@extends('businzo.layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-slate-800">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-accent/20 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" data-aos="fade-up">
        <h1 class="text-4xl md:text-5xl font-bold font-['Outfit'] mb-6">Get in <span class="gradient-text">Touch</span></h1>
        <p class="text-xl text-gray-400 max-w-3xl mx-auto">Have a project in mind? Let's discuss how we can help you bring your ideas to life.</p>
    </div>
</div>

<section class="py-16 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            <!-- Contact Info -->
            <div data-aos="fade-right">
                <h2 class="text-3xl font-bold font-['Outfit'] mb-8">Let's build something great together.</h2>
                <p class="text-gray-400 mb-10 leading-relaxed">
                    Whether you're looking for a dedicated team of engineers, a custom SaaS application, or an AI-powered enterprise solution, our team is ready to deliver. Reach out to us for a free consultation.
                </p>

                <div class="space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-map text-2xl text-blue-500'></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold font-['Outfit'] mb-1">Our Headquarters</h4>
                            <p class="text-gray-400">123 Innovation Drive,<br>Tech District, TD 12345</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-envelope text-2xl text-accent'></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold font-['Outfit'] mb-1">Email Us</h4>
                            <a href="mailto:hello@businzo.com" class="text-gray-400 hover:text-white transition-colors">hello@businzo.com</a>
                            <p class="text-sm text-slate-500 mt-1">We typically reply within 24 hours.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-phone text-2xl text-emerald-500'></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold font-['Outfit'] mb-1">Call Us</h4>
                            <p class="text-gray-400">+1 (555) 123-4567</p>
                            <p class="text-sm text-slate-500 mt-1">Mon-Fri, 9am-6pm EST</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-12 border-t border-slate-800">
                    <h4 class="text-lg font-bold font-['Outfit'] mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all"><i class='bx bxl-linkedin text-xl'></i></a>
                        <a href="#" class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-blue-400 hover:text-white transition-all"><i class='bx bxl-twitter text-xl'></i></a>
                        <a href="#" class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-pink-600 hover:text-white transition-all"><i class='bx bxl-instagram text-xl'></i></a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="glass-panel p-8 rounded-2xl border border-white/10" data-aos="fade-left">
                @if(session('success'))
                    <div class="bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 px-4 py-3 rounded-lg mb-6 flex items-center gap-2">
                        <i class='bx bx-check-circle text-xl'></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                <form action="{{ route('businzo.contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-slate-300 mb-2">First Name</label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="John" required>
                            @error('first_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-slate-300 mb-2">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="Doe">
                            @error('last_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Work Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" placeholder="john@company.com" required>
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="service" class="block text-sm font-medium text-slate-300 mb-2">Interested Service</label>
                        <select id="service" name="service" class="w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                            <option value="">Select a service...</option>
                            <option value="web" {{ old('service') == 'web' ? 'selected' : '' }}>Web Application Development</option>
                            <option value="mobile" {{ old('service') == 'mobile' ? 'selected' : '' }}>Mobile Application Development</option>
                            <option value="ai" {{ old('service') == 'ai' ? 'selected' : '' }}>AI & Data Pipelines</option>
                            <option value="custom" {{ old('service') == 'custom' ? 'selected' : '' }}>Custom Software Solutions</option>
                        </select>
                        @error('service') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Project Details</label>
                        <textarea id="message" name="message" rows="5" class="w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors resize-none" placeholder="Tell us a little bit about your project and goals..." required>{{ old('message') }}</textarea>
                        @error('message') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full btn-premium py-4 rounded-lg text-black font-bold text-lg flex justify-center items-center gap-2">
                        Send Message <i class='bx bx-send'></i>
                    </button>
                    
                    <p class="text-xs text-gray-500 text-center mt-4">By submitting this form, you agree to our privacy policy and terms of service.</p>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection
