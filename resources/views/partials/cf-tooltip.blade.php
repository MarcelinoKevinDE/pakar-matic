{{--
    Reusable Educational Tooltip Component
    Usage: @include('partials.cf-tooltip')
    Or embed the modal trigger button anywhere on the page.
--}}

{{-- ── Trigger Button ──────────────────────────────────────────────────────── --}}
<button type="button"
        class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1"
        data-bs-toggle="modal" data-bs-target="#cfExplainModal"
        title="How does this work?">
    <i class="bi bi-lightbulb"></i>
    How does CF work?
</button>

{{-- ── Modal ────────────────────────────────────────────────────────────────── --}}
<div class="modal fade" id="cfExplainModal" tabindex="-1"
     aria-labelledby="cfExplainModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">

            {{-- Header --}}
            <div class="modal-header text-white"
                 style="background: linear-gradient(135deg,#1A1A2E,#E8461A);">
                <div>
                    <h5 class="modal-title fw-700 mb-0" id="cfExplainModalLabel">
                        <i class="bi bi-cpu me-2"></i>
                        Understanding the Certainty Factor (CF) Method
                    </h5>
                    <small class="opacity-75">How this expert system reaches its conclusions</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body p-4">

                {{-- Section 1: What is CF? --}}
                <div class="mb-4">
                    <h6 class="fw-700 mb-2" style="color:#E8461A;">
                        <i class="bi bi-question-circle-fill me-1"></i> What is the Certainty Factor?
                    </h6>
                    <p class="text-muted mb-0">
                        The <strong>Certainty Factor (CF)</strong> is a numerical value between
                        <code>0.0</code> and <code>1.0</code> that represents an expert's
                        <strong>confidence</strong> that a particular damage (kerusakan) is present,
                        given a set of observed symptoms (gejala).
                        It was originally introduced in the MYCIN medical expert system at Stanford
                        University and is widely used in rule-based AI systems.
                    </p>
                </div>

                <hr class="my-3">

                {{-- Section 2: CF Values --}}
                <div class="mb-4">
                    <h6 class="fw-700 mb-3" style="color:#E8461A;">
                        <i class="bi bi-sliders me-1"></i> CF Scale
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>CF Value</th>
                                    <th>Confidence Level</th>
                                    <th>Meaning</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code class="text-success fw-700">0.8 – 1.0</code></td>
                                    <td><span class="badge bg-success">VERY HIGH</span></td>
                                    <td class="text-start">Expert is almost certain. Strongly indicates this damage.</td>
                                </tr>
                                <tr>
                                    <td><code class="text-primary fw-700">0.6 – 0.79</code></td>
                                    <td><span class="badge bg-primary">HIGH</span></td>
                                    <td class="text-start">Expert is quite confident. Likely this damage.</td>
                                </tr>
                                <tr>
                                    <td><code class="text-warning fw-700">0.4 – 0.59</code></td>
                                    <td><span class="badge bg-warning text-dark">MEDIUM</span></td>
                                    <td class="text-start">Some evidence, but not conclusive.</td>
                                </tr>
                                <tr>
                                    <td><code class="text-secondary fw-700">0.0 – 0.39</code></td>
                                    <td><span class="badge bg-secondary">LOW</span></td>
                                    <td class="text-start">Weak evidence. Consider other possibilities.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr class="my-3">

                {{-- Section 3: Combination Formula --}}
                <div class="mb-4">
                    <h6 class="fw-700 mb-2" style="color:#E8461A;">
                        <i class="bi bi-calculator me-1"></i> The Combination Formula
                    </h6>
                    <p class="text-muted mb-2">
                        When <strong>multiple symptoms</strong> all point to the same damage,
                        their individual CF values are <em>combined sequentially</em> using:
                    </p>
                    <div class="p-3 rounded-3 text-center"
                         style="background:#F8F9FA; border:2px solid #dee2e6;">
                        <code class="fs-5 text-dark">
                            CF<sub>combined</sub> = CF<sub>old</sub> + CF<sub>new</sub> &times; (1 &minus; CF<sub>old</sub>)
                        </code>
                    </div>
                    <p class="text-muted mt-2 mb-0 small">
                        This formula ensures the combined CF never exceeds <strong>1.0</strong>
                        (100% certainty) and that each new symptom proportionally increases the
                        overall confidence.
                    </p>
                </div>

                <hr class="my-3">

                {{-- Section 4: Worked Example --}}
                <div class="mb-2">
                    <h6 class="fw-700 mb-3" style="color:#E8461A;">
                        <i class="bi bi-journal-code me-1"></i> Worked Example
                    </h6>

                    <p class="text-muted small mb-2">
                        Suppose three symptoms all point to <em>"Carburettor Blockage"</em>
                        with CF values of <code>0.6</code>, <code>0.7</code>, and <code>0.5</code>:
                    </p>

                    <div class="row g-2">
                        {{-- Step 1 --}}
                        <div class="col-12">
                            <div class="d-flex align-items-start gap-2 p-2 rounded-2"
                                 style="background:#f0fdf4; border-left:3px solid #22c55e">
                                <span class="badge bg-success mt-1">Step 1</span>
                                <div class="small">
                                    <strong>Symptom 1</strong> (CF = 0.6): Starting value.<br>
                                    <code>CF = 0.0 + 0.6 × (1 − 0.0) = <strong>0.6000</strong></code>
                                </div>
                            </div>
                        </div>
                        {{-- Step 2 --}}
                        <div class="col-12">
                            <div class="d-flex align-items-start gap-2 p-2 rounded-2"
                                 style="background:#eff6ff; border-left:3px solid #3b82f6">
                                <span class="badge bg-primary mt-1">Step 2</span>
                                <div class="small">
                                    <strong>Symptom 2</strong> (CF = 0.7): Combine with previous.<br>
                                    <code>CF = 0.6 + 0.7 × (1 − 0.6) = 0.6 + 0.28 = <strong>0.8800</strong></code>
                                </div>
                            </div>
                        </div>
                        {{-- Step 3 --}}
                        <div class="col-12">
                            <div class="d-flex align-items-start gap-2 p-2 rounded-2"
                                 style="background:#fefce8; border-left:3px solid #eab308">
                                <span class="badge bg-warning text-dark mt-1">Step 3</span>
                                <div class="small">
                                    <strong>Symptom 3</strong> (CF = 0.5): Combine again.<br>
                                    <code>CF = 0.88 + 0.5 × (1 − 0.88) = 0.88 + 0.06 = <strong>0.9400</strong></code>
                                </div>
                            </div>
                        </div>
                        {{-- Result --}}
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-2 p-2 rounded-2"
                                 style="background:#fdf2f8; border-left:3px solid #E8461A">
                                <i class="bi bi-trophy-fill text-danger fs-5"></i>
                                <div class="small">
                                    <strong>Final Result:</strong> CF = <code>0.9400</code> (94%) →
                                    <span class="badge bg-success">VERY HIGH confidence</span>
                                    → Diagnosis: <em>Carburettor Blockage</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="modal-footer bg-light">
                <p class="text-muted small mb-0 me-auto">
                    <i class="bi bi-info-circle me-1"></i>
                    CF values in our rule base were set by a certified motorcycle mechanic with 15+ years of experience.
                </p>
                <button type="button" class="btn btn-primary btn-sm" data-bs-dismiss="modal">
                    Got it!
                </button>
            </div>

        </div>
    </div>
</div>