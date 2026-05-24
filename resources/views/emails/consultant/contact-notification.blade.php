<p>A new bespoke project consultation request has been submitted.</p>
<p><strong>Client:</strong> {{ $project->user->name }} ({{ $project->user->email }})</p>
<p><strong>Project Title:</strong> {{ $project->project_title }}</p>
<p><strong>Current Step:</strong> {{ $project->current_step }}</p>
<p><strong>Consultant:</strong> {{ $project->consultant->name }}</p>
<p><strong>Created:</strong> {{ $project->created_at->format('F j, Y') }}</p>
