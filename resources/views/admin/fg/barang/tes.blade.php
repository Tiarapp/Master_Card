<tbody>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</a></td>
            <td class="text-right">
                <div class="actions">
                    <a href="{{ route('update_status', $user->user_id) }}" id="suspendd" data-toggle="modal"
                        data-target="#demoModal{{ $user->user_id }}"
                        class="btn btn-sm bg-danger-light">Suspend</a>
                </div>
            </td>
             <!-- Modal Example Start-->
             <div class="modal fade" id="demoModal{{ $user->user_id }}" value="{{$user->user_id}}" tabindex="-1" role="dialog" aria- labelledby="demoModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="demoModalLabel{{ $user->user_id }}">
                                Reason to Suspend This User</h5>
                            <button type="button" class="close"
                                data-dismiss="modal" aria- label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <div class="col-md-10">
                            <textarea rows="5" cols="15" class="form-control summernote" placeholder="Compose mail here" name="details"
                                value="details" id="details" required></textarea>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                            <a href="{{ route('update_status', $user->user_id) }}"
                                class="btn btn-primary"><i
                                    class="fa fa-send m-r-5"></i><span>Send</span></a>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Modal Example End-->
        </tr>
    @endforeach
</tbody>