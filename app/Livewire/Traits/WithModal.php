<?php

namespace App\Livewire\Traits;

trait WithModal
{
    public $isEditMode = false;

    public function showCreateModalHook($modalName)
    {
        $this->resetForm();
        $this->isEditMode = false;
        $this->dispatch('open-modal', name: $modalName);
    }

    public function showEditModalHook($modalName)
    {
        $this->resetForm();
        $this->isEditMode = true;
        $this->dispatch('open-modal', name: $modalName);
    }

    public function closeModal($modalName)
    {
        $this->dispatch('close-modal', name: $modalName);
    }

    // Anda bisa membuat method resetForm abstract agar setiap komponen wajib mengimplementasikannya
    abstract protected function resetForm();
}