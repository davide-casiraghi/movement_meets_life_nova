{{-- Next to the search field of the patient list (render hook, see GestionalePanelProvider). --}}
<select wire:model.live="status" class="gest-select gest-status-select" aria-label="Stato dei pazienti">
    <option value="all">Tutti</option>
    <option value="active">Attivi</option>
    <option value="archived">Archiviati</option>
</select>
