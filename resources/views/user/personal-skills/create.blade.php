@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">

        {{-- Main Form --}}
        <form action="{{ route('personal-skills.store', $personalSkill->id ?? null) }}" method="POST">
            @csrf
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-success">GDR 07 - Personal Skills & Training Record</h2>
                <button type="submit" class="btn btn-primary">{{ isset($personalSkill) ? 'Update' : 'Create' }}</button>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label for="employee_name" class="form-label">Employee Name</label>
                    <input type="text" name="employee_name" class="form-control"
                        value="{{ old('employee_name', $personalSkill->employee_name ?? '') }}" required>
                </div>
                <div class="col-sm-6">
                    <label for="route_to_further_competence" class="form-label">Route to Further Competence</label>
                    <textarea name="route_to_further_competence" class="form-control" rows="3">{{ old('route_to_further_competence', $personalSkill->route_to_further_competence ?? '') }}</textarea>
                </div>
            </div>

            {{-- Tabs --}}
            <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="trainingMatrix-tab" data-bs-toggle="tab"
                        data-bs-target="#trainingMatrix" type="button" role="tab">Training Matrix</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="presentCompetence-tab" data-bs-toggle="tab"
                        data-bs-target="#presentCompetence" type="button" role="tab">Present Competence</button>
                </li>
            </ul>

            <div class="tab-content mt-3" id="myTabContent">
                {{-- Training Matrix Tab --}}
                <div class="tab-pane fade show active" id="trainingMatrix" role="tabpanel">
                    <h4 class="text-success">Add New Training Record</h4>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <label for="courseName" class="form-label">Course Name</label>
                            <input type="text" name="courseName" class="form-control" id="courseName">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="courseDate" class="form-label">Date of Course</label>
                            <input type="date" name="courseDate" class="form-control" id="courseDate">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="renewalDate" class="form-label">Renewal Date</label>
                            <input type="date" name="renewalDate" class="form-control" id="renewalDate">
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label for="courseDescription" class="form-label">Description of Course and Certificates Attained</label>
                            <textarea name="courseDescription" class="form-control" id="courseDescription" rows="3"></textarea>
                        </div>
                    </div>

                    @if (!empty($personalSkill?->courses))
                        @foreach ($personalSkill->courses as $course)
                            <div class="card p-3 mt-3">
                              <div class="d-flex">
                              <button type="button"
                                  class="btn btn-sm btn-outline-danger mt-2 ms-auto delete-course"
                                  data-url="{{ route('skills-course.destroy', [$personalSkill->id, $course->id]) }}"
                                  data-id="{{ $course->id }}">
                                  <i class="mdi mdi-delete text-danger"></i>
                              </button>

                              </div>
                                <h5 class="card-title">{{ $course->course_name }}</h5>
                                <p class="card-text">Date: {{ $course->course_date }}</p>
                                <p class="card-text">Renewal Date: {{ $course->renewal_date }}</p>
                                <p class="card-text">Description: {{ $course->course_description }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- Present Competence Tab --}}
                <div class="tab-pane fade" id="presentCompetence" role="tabpanel">
                    <h4 class="text-success">Add New Competence Record</h4>
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="competenceIn" class="form-label">Competent In</label>
                            <input type="text" name="competenceIn" class="form-control" id="competenceIn">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="competenceLevel" class="form-label">Competence Level</label>
                            <input type="text" name="competenceLevel" class="form-control" id="competenceLevel">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="experienceLevel" class="form-label">Experience Level</label>
                            <select name="experienceLevel" class="form-select" id="experienceLevel">
                                <option value="">Select Experience Level</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>

                    {{-- Competence Cards --}}
                    @if ($personalSkill && $personalSkill->competencies && $personalSkill->competencies->count())
                        @foreach ($personalSkill->competencies as $competence)
                            <div class="card p-3 mt-3">
                              <div class="d-flex">
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger mt-2 ms-auto delete-competence"
                                    data-url="{{ route('skills-competence.destroy', [$personalSkill->id, $competence->id]) }}"
                                    data-id="{{ $competence->id }}">
                                    <i class="mdi mdi-delete text-danger"></i>
                                </button>
                              </div>
                                <h5 class="card-title">{{ $competence->competence_name }}</h5>
                                <p class="card-text">Level: {{ $competence->competence_level }}</p>
                                <p class="card-text">Experience: {{ $competence->experience_level }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    function handleDelete(className, type) {
        document.querySelectorAll(className).forEach(button => {
            button.addEventListener('click', function () {
                const url = this.dataset.url;
                const id = this.dataset.id;

                if (!confirm(`Are you sure you want to delete this ${type}?`)) return;

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Optionally remove the card from DOM
                        this.closest('.card').remove();
                    } else {
                        return response.json().then(data => {
                            alert(data.message || `Failed to delete ${type}.`);
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Something went wrong!');
                });
            });
        });
    }

    handleDelete('.delete-competence', 'competence');
    handleDelete('.delete-course', 'course');

});
</script>
@endsection
