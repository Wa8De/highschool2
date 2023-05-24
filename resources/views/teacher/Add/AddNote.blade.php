@extends('layouts.app')

@section('content')

<div class="row-6 d-flex">
    <div class="form-group ">
        <label for="class">Select Class:</label>
        <select name="class" id="classSelect" class="form-select">
            <option value="">Select a class</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->NameClass }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group "> 
        <div id="studentContainer" style="display: none;">
            <label for="student">Select Student:</label>
            <select name="student" id="studentSelect" class="form-select">
                <option value="">Select a student</option>
            </select>
        </div>
    </div>
    <div class="form-group "> 
        <div id="moduleContainer" style="display: none;">
            <label for="module">Select Module:</label>
            <select name="module" id="moduleSelect" class="form-select">
                <option value="">Select a module</option>
            </select>
        </div>
    </div>
</div>

<script>
    const classes = @json($classes);
    const modules = @json($modules);

    document.getElementById('classSelect').addEventListener('change', function() {
        const classId = this.value;
        const studentContainer = document.getElementById('studentContainer');
        const studentSelect = document.getElementById('studentSelect');
        const moduleContainer = document.getElementById('moduleContainer');
        const moduleSelect = document.getElementById('moduleSelect');
        
        studentSelect.innerHTML = '<option value="">Select a student</option>';
        moduleSelect.innerHTML = '<option value="">Select a module</option>';

        if (classId !== '') {
            const selectedClass = classes.find(cls => cls.id == classId);
            selectedClass.students.forEach(student => {
                const option = document.createElement('option');
                option.value = student.id;
                option.textContent = student.name;
                studentSelect.appendChild(option);
            });
            studentContainer.style.display = 'block';
        } else {
            studentContainer.style.display = 'none';
        }
    });

    document.getElementById('studentSelect').addEventListener('change', function() {
        const studentId = this.value;
        const moduleContainer = document.getElementById('moduleContainer');
        const moduleSelect = document.getElementById('moduleSelect');

        moduleSelect.innerHTML = '<option value="">Select a module</option>';

        if (studentId !== '') {
            var selectedClassId = document.getElementById('classSelect').value;
            var selectedClass = classes.find(cls => cls.id == selectedClassId);
            var selectedStudent = selectedClass.students.find(student => student.id == studentId);

            selectedStudent.modules.forEach(moduleId => {
                var module = modules.find(module => module.id == moduleId);
                var option = document.createElement('option');
                option.value = module.id;
                option.textContent = module.name;
                moduleSelect.appendChild(option);
            });

            moduleContainer.style.display = 'inline';
        } else {
            moduleContainer.style.display = 'none';
        }
    });
</script>

@endsection
