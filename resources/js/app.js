//---------------------------------------------------------------
// Livewire & Alpine
//---------------------------------------------------------------
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm'
import ui from '@alpinejs/ui'

Alpine.plugin(ui)
Livewire.start()

//---------------------------------------------------------------
// Helpers
//---------------------------------------------------------------
import Helpers from './helpers'
window.Helpers = Helpers
