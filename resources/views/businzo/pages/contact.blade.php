@extends('businzo.layouts.app')

@section('title', 'Contact Businzo Technologies')

@section('content')
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/10">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-accent/20 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" data-aos="fade-up">
        <h1 class="text-4xl md:text-5xl font-bold font-['Outfit'] mb-6">Book a <span class="gradient-text-accent">Consultation</span></h1>
        <p class="text-xl text-muted max-w-3xl mx-auto">Ready to build AI-powered, production-ready software? Tell us about your project — we respond within 24 hours with a clear next step.</p>
    </div>
</div>

<section class="py-16 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            
            <!-- Contact Info -->
            <div data-aos="fade-right">
                <h2 class="text-3xl font-bold font-['Outfit'] mb-8">Let's scope your next platform.</h2>
                <p class="text-muted mb-10 leading-relaxed">
                    We engineer AI-powered software that ships — web platforms, mobile products, MCP integrations, and intelligent automation. Secure, scalable, and built to accelerate your business growth.
                </p>

                <div class="space-y-8">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-buildings text-2xl text-primary'></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold font-['Outfit'] mb-1">What We Build</h4>
                            <p class="text-muted">AI-powered web & mobile platforms, MCP integrations, intelligent automation, and custom SaaS — production-ready from day one.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-envelope text-2xl gradient-text-accent'></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold font-['Outfit'] mb-1">Email Us</h4>
                            <a href="mailto:sales@businzo.com" class="text-muted hover:text-foreground transition-colors">hello@businzo.com</a>
                            <p class="text-sm text-subtle mt-1">For project inquiries, proposals, and partnership discussions.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-briefcase text-2xl text-emerald-500'></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold font-['Outfit'] mb-1">Careers</h4>
                            <a href="mailto:careers@businzo.com" class="text-muted hover:text-foreground transition-colors">careers@businzo.com</a>
                            <p class="text-sm text-subtle mt-1">We're hiring for multliple tech stack roles - software developers, architects, mobile engineers, and AI specialists.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-12 border-t border-white/10">
                    <h4 class="text-lg font-bold font-['Outfit'] mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="https://in.linkedin.com/company/businzotech" class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center text-muted hover:bg-primary hover:text-foreground transition-all"><i class='bx bxl-linkedin text-xl'></i></a>
                        <a href="https://x.com/businzotech" class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center text-muted hover:bg-primary-light hover:text-foreground transition-all"><i class='bx bxl-twitter text-xl'></i></a>
                        <a href="https://www.facebook.com/BusinzoTechnologies" class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center text-muted hover:bg-pink-600 hover:text-foreground transition-all"><i class='bx bxl-facebook text-xl'></i></a>
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
                <div id="contact-form-alert" class="hidden mb-6 px-4 py-3 rounded-lg flex items-start gap-2" role="alert" aria-live="polite"></div>

                <form id="contact-form" action="{{ route('businzo.contact.submit') }}" method="POST" class="space-y-6" novalidate>
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="contact-field" data-field="first_name">
                            <label for="first_name" class="block text-sm font-medium text-muted mb-2">First Name <span class="gradient-gradient-text-accent">*</span></label>
                            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" maxlength="255"
                                class="contact-input w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="John" aria-describedby="first_name-error first_name-hint">
                            <p id="first_name-hint" class="text-subtle text-xs mt-1">Letters only, at least 3 characters.</p>
                            <p id="first_name-error" class="contact-error text-red-400 text-xs mt-1 hidden" role="alert"></p>
                            @error('first_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="contact-field" data-field="last_name">
                            <label for="last_name" class="block text-sm font-medium text-muted mb-2">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" autocomplete="family-name" maxlength="255"
                                class="contact-input w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="Doe" aria-describedby="last_name-error last_name-hint">
                            <p id="last_name-hint" class="text-subtle text-xs mt-1">Optional. Letters only, min 3 characters if provided.</p>
                            <p id="last_name-error" class="contact-error text-red-400 text-xs mt-1 hidden" role="alert"></p>
                            @error('last_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="contact-field" data-field="email">
                        <label for="email" class="block text-sm font-medium text-muted mb-2">Work Email <span class="gradient-gradient-text-accent">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" maxlength="255" inputmode="email"
                            class="contact-input w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="john@company.com" aria-describedby="email-error email-hint">
                        <p id="email-hint" class="text-subtle text-xs mt-1">Use your work or business email address.</p>
                        <p id="email-error" class="contact-error text-red-400 text-xs mt-1 hidden" role="alert"></p>
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="contact-field" data-field="service">
                        <label for="service" class="block text-sm font-medium text-muted mb-2">Interested Service</label>
                        <select id="service" name="service"
                            class="contact-input w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            aria-describedby="service-error">
                            <option value="">Select a service...</option>
                            <option value="web" {{ old('service') == 'web' ? 'selected' : '' }}>Web Application Development</option>
                            <option value="mobile" {{ old('service') == 'mobile' ? 'selected' : '' }}>Mobile Application Development</option>
                            <option value="ai" {{ old('service') == 'ai' ? 'selected' : '' }}>AI, MCP & Automation</option>
                            <option value="custom" {{ old('service') == 'custom' ? 'selected' : '' }}>Custom Software Development</option>
                            <option value="consulting" {{ old('service') == 'consulting' ? 'selected' : '' }}>Architecture & Consulting</option>
                        </select>
                        <p id="service-error" class="contact-error text-red-400 text-xs mt-1 hidden" role="alert"></p>
                        @error('service') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="contact-field" data-field="message">
                        <div class="flex items-center justify-between mb-2">
                            <label for="message" class="block text-sm font-medium text-muted">Project Details <span class="gradient-gradient-text-accent">*</span></label>
                            <span id="message-counter" class="text-xs text-subtle">0 / 1000</span>
                        </div>
                        <textarea id="message" name="message" rows="5" maxlength="1000"
                            class="contact-input w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors resize-none"
                            placeholder="Tell us about your platform — number of users, key features, timeline, and any specific requirements..."
                            aria-describedby="message-error message-hint">{{ old('message') }}</textarea>
                        <p id="message-hint" class="text-subtle text-xs mt-1">Minimum 3 characters. Letters, numbers, spaces, and . , ' # - allowed.</p>
                        <p id="message-error" class="contact-error text-red-400 text-xs mt-1 hidden" role="alert"></p>
                        @error('message') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" id="contact-submit-btn"
                        class="w-full btn-premium py-4 rounded-lg font-bold text-lg flex justify-center items-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed transition-opacity">
                        <span id="contact-submit-label">Book a Consultation</span>
                        <i id="contact-submit-icon" class='bx bx-send'></i>
                        <i id="contact-submit-spinner" class='bx bx-loader-alt bx-spin hidden'></i>
                    </button>
                    
                    <p class="text-xs text-muted text-center mt-4">By submitting this form, you agree to our <a href="{{ route('businzo.privacy') }}" class="text-muted hover:text-foreground underline">privacy policy</a> and <a href="{{ route('businzo.terms') }}" class="text-muted hover:text-foreground underline">terms of service</a>.</p>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contact-form');
    if (!form) return;

    const submitBtn = document.getElementById('contact-submit-btn');
    const submitLabel = document.getElementById('contact-submit-label');
    const submitIcon = document.getElementById('contact-submit-icon');
    const submitSpinner = document.getElementById('contact-submit-spinner');
    const formAlert = document.getElementById('contact-form-alert');
    const messageField = document.getElementById('message');
    const messageCounter = document.getElementById('message-counter');

    const RULES = {
        first_name: {
            required: true,
            validate: (value) => {
                if (!value.trim()) return 'First name is required.';
                if (value.trim().length < 3) return 'First name must be at least 3 characters.';
                if (value.length > 255) return 'First name cannot exceed 255 characters.';
                if (!/^[a-zA-Z]+$/.test(value.trim())) return 'First name may only contain letters.';
                return '';
            },
        },
        last_name: {
            required: false,
            validate: (value) => {
                if (!value.trim()) return '';
                if (value.trim().length < 3) return 'Last name must be at least 3 characters if provided.';
                if (value.length > 255) return 'Last name cannot exceed 255 characters.';
                if (!/^[a-zA-Z]+$/.test(value.trim())) return 'Last name may only contain letters.';
                return '';
            },
        },
        email: {
            required: true,
            validate: (value) => {
                const trimmed = value.trim();
                if (!trimmed) return 'Email address is required.';
                if (trimmed.length < 3) return 'Email must be at least 3 characters.';
                if (trimmed.length > 255) return 'Email cannot exceed 255 characters.';
                const emailPattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/;
                if (!emailPattern.test(trimmed)) return 'Please enter a valid email address.';
                if (/^(test|example|noreply)@/i.test(trimmed)) return 'Please use a real work or business email.';
                return '';
            },
        },
        service: {
            required: false,
            validate: (value) => {
                if (!value) return '';
                const allowed = ['web', 'mobile', 'ai', 'custom', 'consulting'];
                if (!allowed.includes(value)) return 'Please select a valid service option.';
                return '';
            },
        },
        message: {
            required: true,
            validate: (value) => {
                const trimmed = value.trim();
                if (!trimmed) return 'Project details are required.';
                if (trimmed.length < 3) return 'Message must be at least 3 characters.';
                if (value.length > 1000) return 'Message cannot exceed 1000 characters.';
                if (!/^[a-zA-Z0-9\s.,'#-]+$/.test(value)) return 'Message contains invalid characters. Use letters, numbers, spaces, and . , \' # - only.';
                return '';
            },
        },
    };

    const touched = {};
    let isSubmitting = false;

    function getField(name) {
        return form.querySelector(`[name="${name}"]`);
    }

    function getErrorEl(name) {
        return document.getElementById(`${name}-error`);
    }

    function setFieldState(name, error) {
        const input = getField(name);
        const errorEl = getErrorEl(name);
        const wrapper = form.querySelector(`[data-field="${name}"]`);

        if (!input || !errorEl) return;

        const baseClasses = ['border-white/10', 'focus:border-primary', 'focus:ring-primary'];
        const invalidClasses = ['border-red-500/70', 'focus:border-red-500', 'focus:ring-red-500'];
        const validClasses = ['border-emerald-500/50', 'focus:border-emerald-500', 'focus:ring-emerald-500'];

        input.classList.remove(...invalidClasses, ...validClasses, ...baseClasses);

        if (error) {
            input.classList.add(...invalidClasses);
            input.setAttribute('aria-invalid', 'true');
            errorEl.textContent = error;
            errorEl.classList.remove('hidden');
            wrapper?.classList.add('shake-once');
            setTimeout(() => wrapper?.classList.remove('shake-once'), 400);
        } else if (touched[name] && input.value.trim()) {
            input.classList.add(...validClasses);
            input.setAttribute('aria-invalid', 'false');
            errorEl.textContent = '';
            errorEl.classList.add('hidden');
        } else {
            input.classList.add(...baseClasses);
            input.setAttribute('aria-invalid', 'false');
            errorEl.textContent = '';
            errorEl.classList.add('hidden');
        }
    }

    function validateField(name, showError = true) {
        const input = getField(name);
        if (!input || !RULES[name]) return true;

        const error = RULES[name].validate(input.value);
        if (showError) setFieldState(name, error);
        return !error;
    }

    function validateForm() {
        let isValid = true;
        let firstInvalid = null;

        Object.keys(RULES).forEach((name) => {
            touched[name] = true;
            const fieldValid = validateField(name, true);
            if (!fieldValid) {
                isValid = false;
                if (!firstInvalid) firstInvalid = getField(name);
            }
        });

        return { isValid, firstInvalid };
    }

    function showFormAlert(message, type = 'error') {
        formAlert.classList.remove('hidden', 'bg-red-500/10', 'border-red-500/50', 'text-red-400', 'bg-emerald-500/10', 'border-emerald-500/50', 'text-emerald-400', 'border');
        if (type === 'error') {
            formAlert.classList.add('bg-red-500/10', 'border', 'border-red-500/50', 'text-red-400');
            formAlert.innerHTML = `<i class='bx bx-error-circle text-xl shrink-0'></i><span>${message}</span>`;
        }
        formAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function hideFormAlert() {
        formAlert.classList.add('hidden');
        formAlert.innerHTML = '';
    }

    function updateMessageCounter() {
        const len = messageField.value.length;
        messageCounter.textContent = `${len} / 1000`;
        messageCounter.classList.toggle('text-red-400', len > 1000);
        messageCounter.classList.toggle('text-amber-400', len >= 900 && len <= 1000);
        messageCounter.classList.toggle('text-subtle', len < 900);
    }

    function debounce(fn, delay) {
        let timer;
        return (...args) => {
            clearTimeout(timer);
            timer = setTimeout(() => fn(...args), delay);
        };
    }

    Object.keys(RULES).forEach((name) => {
        const input = getField(name);
        if (!input) return;

        input.addEventListener('blur', () => {
            touched[name] = true;
            validateField(name, true);
        });

        input.addEventListener('input', debounce(() => {
            if (touched[name] || input.value.trim()) {
                touched[name] = true;
                validateField(name, true);
            }
            hideFormAlert();
        }, 300));
    });

    messageField.addEventListener('input', updateMessageCounter);
    updateMessageCounter();

    form.addEventListener('submit', function (e) {
        if (isSubmitting) {
            e.preventDefault();
            return;
        }

        hideFormAlert();
        const { isValid, firstInvalid } = validateForm();

        if (!isValid) {
            e.preventDefault();
            showFormAlert('Please fix the highlighted fields before submitting.');
            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        isSubmitting = true;
        submitBtn.disabled = true;
        submitLabel.textContent = 'Sending...';
        submitIcon.classList.add('hidden');
        submitSpinner.classList.remove('hidden');
    });
});
</script>
@endpush

