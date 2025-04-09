@extends('layouts.master')

@section('css')
    @toastr_css
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Label Styling */
        label {
            font-size: 1.2rem;
            font-weight: 600;
            margin-top: 1.5rem;
            color: #2d1f8a;
        }

        .image-label {
            margin-top: 1.5rem;
        }

        /* Select2 Multiple Select Styling */
        .select2-container--default .select2-selection--multiple {
            border-radius: 8px;
            min-height: 60px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #2d1f8a;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1.1rem;
            padding: 0.3rem 0.6rem;
        }

        /* Form Control Styling */
        .form-control,
        .custom-select {
            font-size: 1.2rem;
            padding: 0.75rem;
            height: 60px;
            margin-bottom: 20px;
        }

        /* Input Fields */
        input[type="text"],
        input[type="file"],
        select {
            font-size: 1.2rem;
            padding: 0.75rem;
            height: 60px;
        }

        /* Optional: Hover and Focus States */
        .form-control:hover,
        .custom-select:hover,
        .form-control:focus,
        .custom-select:focus {
            border-color: #2d1f8a;
            box-shadow: 0 0 0 0.3rem rgba(45, 31, 138, 0.25);
        }

        /* Button Styling */
        .btn {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
        }

        /* Answer Type Toggle Buttons */
        .answer-type-toggle {
            margin-bottom: 10px;
        }
        
        .answer-type-toggle .btn {
            margin-right: 5px;
        }
        
        /* Image Preview */
        .answer-image-preview {
            max-width: 150px;
            max-height: 150px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
            display: none;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .form-control,
            .custom-select {
                font-size: 1.1rem;
                padding: 0.6rem;
                height: 50px;
            }

            label {
                font-size: 1.1rem;
            }
        }
    </style>
@endsection

@section('title')
    إضافة سؤال جديد
@endsection

@section('page-header')
@section('PageTitle')
    إضافة سؤال جديد
@endsection
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ session()->get('error') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ route('questions.store') }}" method="post" autocomplete="off"
                    enctype="multipart/form-data" id="questionForm">
                    @csrf

                    <div class="form-row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label>اسم الاختبار :</label>
                                <select class="custom-select mr-sm-2 @error('quizz_id') is-invalid @enderror"
                                    name="quizz_id[]" id="quizz_select2" multiple>
                                    @foreach ($quizzes as $quizz)
                                        <option value="{{ $quizz->id }}"
                                            {{ in_array($quizz->id, old('quizz_id', [])) ? 'selected' : '' }}>
                                            {{ $quizz->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('quizz_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col">
                            <label for="title">السؤال</label>
                            <textarea name="title" id="input-name" class="form-control summernote form-control-lg mb-15" rows="3" autofocus>{{ old('title') }}</textarea>
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col">
                            <label class="image-label" for="question_image">صورة السؤال</label>
                            <input type="file" name="question_image" id="question_image" class="form-control"
                                accept="image/*">
                            @error('question_image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col">
                            <label>نوع السؤال</label>
                            <select name="question_type" id="question_type" class="form-control custom-select"
                                onchange="toggleAnswerFields()" style="height: 5.5rem;">
                                <option value="true_false" {{ old('question_type') == 'true_false' ? 'selected' : '' }}>
                                    صحيح أو خطأ</option>
                                <option value="multiple_choice"
                                    {{ old('question_type') == 'multiple_choice' ? 'selected' : '' }}>اختيار من متعدد
                                </option>
                            </select>
                            @error('question_type')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div id="number_of_choices_container" class="form-row mb-3" style="display: none;">
                        <div class="col">
                            <label>عدد الاختيارات</label>
                            <select name="number_of_choices" id="number_of_choices" class="form-control custom-select"
                                style="height: 5.5rem;" onchange="updateAnswerFields()">
                                <option value="2" {{ old('number_of_choices') == '2' ? 'selected' : '' }}>2
                                    اختيارات</option>
                                <option value="3" {{ old('number_of_choices') == '3' ? 'selected' : '' }}>3
                                    اختيارات</option>
                                <option value="4" {{ old('number_of_choices') == '4' ? 'selected' : '' }}>4
                                    اختيارات</option>
                            </select>
                            @error('number_of_choices')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div id="multiple_choice_answers" class="form-row mb-3" style="display: none;">
                        <div class="col">
                            <label style="margin-top: 2px; margin-bottom: 2px">الاختيارات</label>
                            <div class="row" id="answers_container">
                                <!-- Answer fields will be dynamically inserted here -->
                            </div>
                        </div>
                    </div>

                    <div id="true_false_answers" class="form-row mb-3" style="display: none;">
                        <div class="col">
                            <label>الاختيارات</label>
                            <div class="row">
                                @for ($i = 5; $i <= 6; $i++)
                                    <div class="col-md-6 mb-3">
                                        <div class="answer-type-toggle mb-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary text-toggle-btn" 
                                                onclick="toggleAnswerType({{ $i }}, 'text')">نص</button>
                                            <button type="button" class="btn btn-sm btn-outline-success image-toggle-btn" 
                                                onclick="toggleAnswerType({{ $i }}, 'image')">صورة</button>
                                        </div>
                                        <div class="answer-text-container-{{ $i }}">
                                            <input type="text" name="answer_{{ $i }}"
                                                placeholder="الاختيار {{ $i - 4 }}" class="form-control"
                                                value="{{ old('answer_' . $i) }}">
                                        </div>
                                        <div class="answer-image-container-{{ $i }}" style="display:none;">
                                            <input type="file" name="answer_{{ $i }}_image" 
                                                class="form-control" accept="image/*"
                                                onchange="previewAnswerImage(event, {{ $i }})">
                                            <img src="" alt="معاينة الصورة" class="answer-image-preview" id="answer-preview-{{ $i }}">
                                            <input type="hidden" name="answer_type_{{ $i }}" value="text">
                                        </div>
                                        @error('answer_' . $i)
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col">
                            <label for="right_answer">الإجابة الصحيحة</label>
                            <select name="right_answer" id="right_answer" class="form-control" style="height: 5.5rem;">
                                <option value="">اختر الإجابة الصحيحة</option>
                            </select>
                            @error('right_answer')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col">
                            <label for="score">الدرجة</label>
                            <select name="score" class="custom-select">
                                <option disabled selected>حدد الدرجة...</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('score') == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                            @error('score')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-success btn-lg mt-3" type="submit">حفظ البيانات</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
@toastr_js
@toastr_render
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // Wait for the document to be ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 for quizzes with RTL support
        $('#quizz_select2').select2({
            dir: 'rtl',
            placeholder: 'اختر الاختبار',
            allowClear: true
        });

        // Initialize image preview functionality
        initImagePreview();

        // Initialize form event listeners
        initFormListeners();

        // Initial form setup
        toggleAnswerFields();
    });

    // Handle image preview
    function initImagePreview() {
        const imageInput = document.getElementById('question_image');
        if (!imageInput) return;

        imageInput.addEventListener('change', function(event) {
            if (!event.target.files || !event.target.files[0]) return;

            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const previewElement = document.getElementById('image-preview');
                if (previewElement) {
                    previewElement.src = e.target.result;
                    previewElement.style.display = 'block';
                }
            };

            reader.readAsDataURL(file);
        });
    }

    // Toggle between text and image answer types
    function toggleAnswerType(answerId, type) {
        const textContainer = document.querySelector(`.answer-text-container-${answerId}`);
        const imageContainer = document.querySelector(`.answer-image-container-${answerId}`);
        const typeInput = document.querySelector(`input[name="answer_type_${answerId}"]`);
        
        if (type === 'text') {
            textContainer.style.display = 'block';
            imageContainer.style.display = 'none';
            typeInput.value = 'text';
        } else {
            textContainer.style.display = 'none';
            imageContainer.style.display = 'block';
            typeInput.value = 'image';
        }
        
        updateRightAnswerOptions();
    }

    // Preview uploaded answer images
    function previewAnswerImage(event, answerId) {
        const preview = document.getElementById(`answer-preview-${answerId}`);
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    // Initialize all form event listeners
    function initFormListeners() {
        // Question type change listener
        const questionTypeSelect = document.getElementById('question_type');
        if (questionTypeSelect) {
            questionTypeSelect.addEventListener('change', toggleAnswerFields);
        }

        // Number of choices change listener
        const numChoicesSelect = document.getElementById('number_of_choices');
        if (numChoicesSelect) {
            numChoicesSelect.addEventListener('change', updateAnswerFields);
        }

        // True/False answer input listeners
        const answer5Input = document.querySelector('input[name="answer_5"]');
        const answer6Input = document.querySelector('input[name="answer_6"]');

        if (answer5Input) answer5Input.addEventListener('input', updateRightAnswerOptions);
        if (answer6Input) answer6Input.addEventListener('input', updateRightAnswerOptions);

        // Form submission validation
        const form = document.getElementById('questionForm');
        if (form) {
            form.addEventListener('submit', validateForm);
        }
    }

    // Toggle between multiple choice and true/false fields
    function toggleAnswerFields() {
        const questionType = document.getElementById('question_type').value;
        const multipleChoiceContainer = document.getElementById('multiple_choice_answers');
        const trueFalseContainer = document.getElementById('true_false_answers');
        const numberOfChoicesContainer = document.getElementById('number_of_choices_container');

        if (questionType === 'multiple_choice') {
            multipleChoiceContainer.style.display = 'block';
            trueFalseContainer.style.display = 'none';
            numberOfChoicesContainer.style.display = 'block';
            updateAnswerFields();
        } else {
            multipleChoiceContainer.style.display = 'none';
            trueFalseContainer.style.display = 'block';
            numberOfChoicesContainer.style.display = 'none';
        }

        updateRightAnswerOptions();
    }

    // Update multiple choice answer fields based on number of choices
    function updateAnswerFields() {
        const numChoices = parseInt(document.getElementById('number_of_choices').value);
        const container = document.getElementById('answers_container');
        container.innerHTML = ''; // Clear existing fields

        for (let i = 1; i <= numChoices; i++) {
            const col = document.createElement('div');
            col.className = 'col-md-' + (12 / numChoices) + ' mb-3';
            
            // Create toggle buttons for text/image
            const toggleDiv = document.createElement('div');
            toggleDiv.className = 'answer-type-toggle mb-2';
            
            const textBtn = document.createElement('button');
            textBtn.type = 'button';
            textBtn.className = 'btn btn-sm btn-outline-primary text-toggle-btn';
            textBtn.textContent = 'نص';
            textBtn.onclick = function() { toggleAnswerType(i, 'text'); };
            
            const imageBtn = document.createElement('button');
            imageBtn.type = 'button';
            imageBtn.className = 'btn btn-sm btn-outline-success image-toggle-btn';
            imageBtn.textContent = 'صورة';
            imageBtn.onclick = function() { toggleAnswerType(i, 'image'); };
            
            toggleDiv.appendChild(textBtn);
            toggleDiv.appendChild(imageBtn);
            col.appendChild(toggleDiv);
            
            // Text input container
            const textContainer = document.createElement('div');
            textContainer.className = `answer-text-container-${i}`;
            
            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.name = 'answer_' + i;
            textInput.id = 'answer_' + i;
            textInput.placeholder = 'الاختيار ' + i;
            textInput.className = 'form-control';
            textInput.value = ''; // Clear any previous value
            textInput.oninput = updateRightAnswerOptions;
            
            textContainer.appendChild(textInput);
            col.appendChild(textContainer);
            
            // Image input container
            const imageContainer = document.createElement('div');
            imageContainer.className = `answer-image-container-${i}`;
            imageContainer.style.display = 'none';
            
            const imageInput = document.createElement('input');
            imageInput.type = 'file';
            imageInput.name = 'answer_image_' + i;
            imageInput.className = 'form-control';
            imageInput.accept = 'image/*';
            imageInput.onchange = function(event) { previewAnswerImage(event, i); };
            
            const imagePreview = document.createElement('img');
            imagePreview.src = '';
            imagePreview.alt = 'معاينة الصورة';
            imagePreview.className = 'answer-image-preview';
            imagePreview.id = `answer-preview-${i}`;
            
            const typeInput = document.createElement('input');
            typeInput.type = 'hidden';
            typeInput.name = `answer_type_${i}`;
            typeInput.value = 'text';
            
            imageContainer.appendChild(imageInput);
            imageContainer.appendChild(imagePreview);
            imageContainer.appendChild(typeInput);
            col.appendChild(imageContainer);
            
            // Add error div
            const errorDiv = document.createElement('div');
            errorDiv.className = 'text-danger';
            errorDiv.id = 'answer_' + i + '_error';
            col.appendChild(errorDiv);
            
            container.appendChild(col);
        }

        updateRightAnswerOptions();
    }

    // Update right answer dropdown options
    function updateRightAnswerOptions() {
        const questionType = document.getElementById('question_type').value;
        const rightAnswerSelect = document.getElementById('right_answer');
        if (!rightAnswerSelect) return;

        // Store current selection if any
        const currentSelection = rightAnswerSelect.value;
        rightAnswerSelect.innerHTML = '<option value="">اختر الإجابة الصحيحة</option>';

        if (questionType === 'true_false') {
            const answer5Type = document.querySelector('input[name="answer_type_5"]')?.value || 'text';
            const answer6Type = document.querySelector('input[name="answer_type_6"]')?.value || 'text';
            
            // For text answers
            if (answer5Type === 'text') {
                const answer5Text = document.querySelector('input[name="answer_5"]')?.value.trim();
                if (answer5Text) rightAnswerSelect.add(new Option(answer5Text, 'answer_5'));
            } else {
                // For image answers, use a placeholder text
                const hasImage5 = document.querySelector('input[name="answer_image_5"]')?.files?.length > 0;
                if (hasImage5) rightAnswerSelect.add(new Option('الصورة في الاختيار 1', 'answer_image_5'));
            }
            
            if (answer6Type === 'text') {
                const answer6Text = document.querySelector('input[name="answer_6"]')?.value.trim();
                if (answer6Text) rightAnswerSelect.add(new Option(answer6Text, 'answer_6'));
            } else {
                const hasImage6 = document.querySelector('input[name="answer_image_6"]')?.files?.length > 0;
                if (hasImage6) rightAnswerSelect.add(new Option('الصورة في الاختيار 2', 'answer_image_6'));
            }
        } else if (questionType === 'multiple_choice') {
            const numChoices = parseInt(document.getElementById('number_of_choices').value);

            for (let i = 1; i <= numChoices; i++) {
                const answerType = document.querySelector(`input[name="answer_type_${i}"]`)?.value || 'text';
                
                if (answerType === 'text') {
                    const answerText = document.querySelector(`input[name="answer_${i}"]`)?.value.trim();
                    if (answerText) rightAnswerSelect.add(new Option(answerText, `answer_${i}`));
                } else {
                    const hasImage = document.querySelector(`input[name="answer_image_${i}"]`)?.files?.length > 0;
                    if (hasImage) rightAnswerSelect.add(new Option(`الصورة في الاختيار ${i}`, `answer_image_${i}`));
                }
            }
        }

        // Restore previous selection if still available
        if (currentSelection && Array.from(rightAnswerSelect.options).some(option => option.value === currentSelection)) {
            rightAnswerSelect.value = currentSelection;
        }
    }

    // Form validation
    function validateForm(event) {
        let isValid = true;
        const questionType = document.getElementById('question_type').value;

        // Clear previous error messages
        clearErrors();

        // Validate quiz selection
        const quizSelect = document.getElementById('quizz_select2');
        if (!quizSelect || quizSelect.value === '') {
            showError('quizz_select2', 'يرجى اختيار اختبار واحد على الأقل');
            isValid = false;
        }

        // Validate question title
        const titleInput = document.getElementById('input-name');
        if (!titleInput || !titleInput.value.trim()) {
            showError('input-name', 'يرجى إدخال عنوان السؤال');
            isValid = false;
        }

        // Validate answers based on question type
        if (questionType === 'multiple_choice') {
            const numChoices = parseInt(document.getElementById('number_of_choices').value);
            for (let i = 1; i <= numChoices; i++) {
                const answerType = document.querySelector(`input[name="answer_type_${i}"]`)?.value || 'text';
                
                if (answerType === 'text') {
                    const answerText = document.querySelector(`input[name="answer_${i}"]`)?.value.trim();
                    if (!answerText) {
                        showError(`answer_${i}`, `يرجى إدخال الاختيار ${i}`);
                        isValid = false;
                    }
                } else {
                    const answerImage = document.querySelector(`input[name="answer_image_${i}"]`);
                    if (!answerImage || !answerImage.files || !answerImage.files[0]) {
                        showError(`answer_${i}`, `يرجى اختيار صورة للاختيار ${i}`);
                        isValid = false;
                    }
                }
            }
        } else {
            // Validate true/false answers
            for (let i = 5; i <= 6; i++) {
                const answerType = document.querySelector(`input[name="answer_type_${i}"]`)?.value || 'text';
                
                if (answerType === 'text') {
                    const answerText = document.querySelector(`input[name="answer_${i}"]`)?.value.trim();
                    if (!answerText) {
                        showError(`answer_${i}`, `يرجى إدخال الاختيار ${i-4}`);
                        isValid = false;
                    }
                } else {
                    const answerImage = document.querySelector(`input[name="answer_image_${i}"]`);
                    if (!answerImage || !answerImage.files || !answerImage.files[0]) {
                        showError(`answer_${i}`, `يرجى اختيار صورة للاختيار ${i-4}`);
                        isValid = false;
                    }
                }
            }
        }

        // Validate right answer selection
        const rightAnswerSelect = document.getElementById('right_answer');
        if (!rightAnswerSelect || !rightAnswerSelect.value) {
            showError('right_answer', 'يرجى اختيار الإجابة الصحيحة');
            isValid = false;
        }

        // Validate score
        const scoreSelect = document.querySelector('select[name="score"]');
        if (!scoreSelect || !scoreSelect.value) {
            showError('score', 'يرجى اختيار الدرجة');
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    }

    // Show error message
    function showError(fieldId, message) {
        const errorDiv = document.getElementById(fieldId + '_error') || createErrorDiv(fieldId);
        errorDiv.textContent = message;
    }

    // Create error div if it doesn't exist
    function createErrorDiv(fieldId) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.createElement('div');
        errorDiv.id = fieldId + '_error';
        errorDiv.className = 'text-danger';
        field.parentNode.insertBefore(errorDiv, field.nextSibling);
        return errorDiv;
    }

    // Clear all error messages
    function clearErrors() {
        const errorDivs = document.querySelectorAll('.text-danger');
        errorDivs.forEach(div => div.textContent = '');
    }
</script>
@endsection