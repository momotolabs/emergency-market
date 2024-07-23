<div>
    <div class="m-4 p-4">
        <h1 class="text-3xl text-primary">Edit Company </h1>
    </div>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="grid grid-cols-2 justify-between p-4">
        <button type="submit" class="bg-primary-500 text-white w-[150px] m-4 p-4 rounded">
            Edit
        </button>
        <button type="button" class="bg-primary-500 text-white w-[150px] m-4 p-4 rounded">
            Cancel
        </button>
        </div>
    </form>
</div>
