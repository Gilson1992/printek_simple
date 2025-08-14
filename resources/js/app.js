import './bootstrap';
import '../css/app.css';

import Inputmask from 'inputmask';
window.Inputmask = Inputmask;

import Swal from 'sweetalert2';
window.Swal = Swal;
import 'sweetalert2/dist/sweetalert2.min.css';

import './../../vendor/power-components/livewire-powergrid/dist/powergrid';

import flatpickr from "flatpickr"; 

import TomSelect from "tom-select";
window.TomSelect = TomSelect;

import SlimSelect from 'slim-select';
window.SlimSelect = SlimSelect;

import { alertaSucesso, alertaFalha, alertaDelete } from './alerts';
window.alertaSucesso = alertaSucesso;
window.alertaFalha   = alertaFalha;
window.alertaDelete  = alertaDelete;
