<h5 class="title mt-2 mb-4" style="">Storico Stati</h5>
<div class="row border-bottom">
    <div class="col-4 font-bold">
        <i class="bi bi-calendar"></i> Data
    </div>
    <div class="col-4 font-bold">
        <i class="bi bi-person"></i> Utente
    </div>
    <div class="col-4 font-bold">
        <i class="bi bi-sliders"></i> Stato
    </div>
</div>
@foreach($invoice->invoice_histories as $item)
    <div class="row">
        <div class="col-4">
            {{date('d/m/Y H:i', strtotime($item->created_at))}}
        </div>
        <div class="col-4">
            {{$item->user->name}}
        </div>
        <div class="col-4">
            {{$item->status}}
        </div>
    </div>
@endforeach
