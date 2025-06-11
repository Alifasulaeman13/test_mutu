@props(['initialType' => 'percentage', 'initialNumerator' => '', 'initialDenominator' => ''])

<div x-data="{
    type: '{{ $initialType }}',
    numerator: '{{ $initialNumerator }}',
    denominator: '{{ $initialDenominator }}',
    init() {
        this.setupListeners();
        this.updateFormula();
        
        // Watch for changes
        this.$watch('type', () => this.updateFormula());
        this.$watch('numerator', () => this.updateFormula());
        this.$watch('denominator', () => this.updateFormula());
    },
    setupListeners() {
        // Listen for calculation type changes
        const calcType = document.querySelector('[name=calculation_type]');
        if (calcType) {
            calcType.addEventListener('change', (e) => {
                this.type = e.target.value;
            });
        }

        // Listen for numerator label changes
        const numLabel = document.querySelector('[name=numerator_label]');
        if (numLabel) {
            ['input', 'change'].forEach(event => {
                numLabel.addEventListener(event, (e) => {
                    this.numerator = e.target.value;
                });
            });
            // Set initial value
            this.numerator = numLabel.value;
        }

        // Listen for denominator label changes
        const denLabel = document.querySelector('[name=denominator_label]');
        if (denLabel) {
            ['input', 'change'].forEach(event => {
                denLabel.addEventListener(event, (e) => {
                    this.denominator = e.target.value;
                });
            });
            // Set initial value
            this.denominator = denLabel.value;
        }
    },
    updateFormula() {
        console.log('Updating formula:', {
            type: this.type,
            numerator: this.numerator,
            denominator: this.denominator
        });
        
        // Update multiplier visibility
        const multiplierGroup = document.querySelector('.calculation-multiplier');
        if (multiplierGroup) {
            multiplierGroup.style.display = this.type === 'percentage' ? 'block' : 'none';
        }
    }
}" 
x-cloak
class="formula-preview">
    <label class="form-sublabel">Preview Formula:</label>
    <div class="formula-box">
        {{-- Percentage Formula --}}
        <div class="formula" 
             x-show.transition.opacity.duration.300ms="type === 'percentage'"
             style="display: none;">
            <div class="fraction">
                <span class="numerator" x-text="numerator || 'Pembilang'"></span>
                <span class="fraction-line"></span>
                <span class="denominator" x-text="denominator || 'Penyebut'"></span>
            </div>
            <span class="operator">×</span>
            <span class="multiplier">100%</span>
        </div>

        {{-- Ratio Formula --}}
        <div class="formula" 
             x-show.transition.opacity.duration.300ms="type === 'ratio'"
             style="display: none;">
            <div class="fraction">
                <span class="numerator" x-text="numerator || 'Pembilang'"></span>
                <span class="fraction-line"></span>
                <span class="denominator" x-text="denominator || 'Penyebut'"></span>
            </div>
        </div>

        {{-- Average Formula --}}
        <div class="formula" 
             x-show.transition.opacity.duration.300ms="type === 'average'"
             style="display: none;">
            <span class="sigma">Σ</span>
            <div class="fraction">
                <span class="numerator" x-text="numerator || 'Total Nilai'"></span>
                <span class="fraction-line"></span>
                <span class="denominator" x-text="denominator || 'n'"></span>
            </div>
        </div>
    </div>
</div>

<style>
.formula-preview {
    margin-top: 1rem;
}

.formula-box {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80px;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    margin-top: 0.5rem;
    font-family: 'Times New Roman', serif;
    font-size: 1.25rem;
}

.formula {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    opacity: 1;
    transition: opacity 0.3s ease-in-out;
}

.formula.hidden {
    opacity: 0;
}

.fraction {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin: 0 0.25rem;
    min-width: 120px;
    position: relative;
}

.numerator, .denominator {
    padding: 0.25rem 0.5rem;
    min-height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    width: 100%;
    transition: all 0.3s ease-in-out;
    background: transparent;
    position: relative;
    z-index: 1;
}

.fraction-line {
    width: 100%;
    height: 2px;
    background: #000;
    min-width: 60px;
    margin: 0.25rem 0;
    transition: width 0.3s ease-in-out;
}

.operator {
    margin: 0 0.5rem;
    font-weight: bold;
}

.multiplier {
    font-weight: bold;
}

.sigma {
    font-size: 2rem;
    margin-right: 0.5rem;
}

[x-cloak] {
    display: none;
}

/* Highlight effect for changes */
.numerator.changed,
.denominator.changed {
    animation: highlight 1s ease-out;
}

@keyframes highlight {
    0% { background-color: rgba(59, 130, 246, 0.1); }
    100% { background-color: transparent; }
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('formulaPreview', () => ({
        highlightChange(element) {
            element.classList.add('changed');
            setTimeout(() => element.classList.remove('changed'), 1000);
        }
    }));
});
</script> 