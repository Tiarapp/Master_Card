<ul>
    <li><x-button-link class="btn-danger btn-sm mr-2" href="{{ route('mastercard.pdfb1', $mastercard->id) }}">Print</x-button-link></li>
    <li><x-button-link class="btn-warning btn-sm mr-2" href="{{ route('mastercard.edit', $mastercard->id) }}">Revisi</x-button-link></li>
    <li><x-button-link class="btn-primary btn-sm mr-2" href="{{ route('mastercard.revisi', $mastercard->id) }}">Edit</x-button-link></li>
</ul>
