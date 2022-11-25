<div class="row justify-content-center mt-5">
    <div class="col-12">
        <div class="card shadow  text-white bg-dark">
            <div class="card-header">Coding Challenge - Network connections</div>
            <div class="card-body">
                <div class="btn-group w-100 mb-3" role="group" aria-label="Basic radio toggle button group">
                    <input wire:click="showTab('showSuggestion')" type="radio" class="btn-check" name="btnradio"
                        id="btnradio1" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="btnradio1" id="get_suggestions_btn">Suggestions(<span
                            class="suggestion_count"></span>)</label>

                    <input wire:click="showTab('showRequest')" type="radio" class="btn-check" name="btnradio"
                        id="btnradio2" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio2" id="get_sent_requests_btn">Sent
                        Requests(<span class="request_count"></span>)</label>

                    <input wire:click="showTab('showReceivedRequest')" type="radio" class="btn-check" name="btnradio"
                        id="btnradio3" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio3" id="get_received_requests_btn">Received
                        Requests(<span class="received_count"></span>)</label>

                    <input wire:click="showTab('showConnections')" type="radio" class="btn-check" name="btnradio"
                        id="btnradio4" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio4" id="get_connections_btn">Connections(<span
                            class="collection_count"></span>)</label>
                </div>
                <hr>

                @if ($showSuggestion)
                    <livewire:suggestions :key="time() . 'suggestion'" />
                @endif

                @if ($showRequest)
                    <livewire:request :mode="'sent'" :key="time() . 'request_sent'" />
                @endif

                @if ($showReceivedRequest)
                    <livewire:request :mode="'received'" :key="time() . 'request_received'" />
                @endif

                @if ($showConnections)
                    <livewire:connection :key="time() . 'connection'" />
                @endif

                <div id="skeleton">
                    @for ($i = 0; $i < 10; $i++)
                        <livewire:skeleton :key="time() . 'skeleton'" />
                    @endfor
                </div>

                <div class="d-flex justify-content-center mt-2 py-3" id="load_more_btn_parent">
                    <button class="btn btn-primary load_more" id="load_more_btn">Load more</button>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="connections_in_common_skeleton" class="d-none">
    <br>
    <span class="fw-bold text-white">Loading.....</span>
    <div class="px-2">
        @for ($i = 0; $i < 10; $i++)
            <livewire:skeleton />
        @endfor
    </div>
</div>
