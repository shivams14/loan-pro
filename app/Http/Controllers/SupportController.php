<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Enums\UserRole;
use App\Mail\Support as MailSupport;
use App\Models\Chat;
use App\Models\Loan;
use App\Models\Support;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class SupportController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->data['title'] = 'Support';
        $this->data['customJS'] = 'admin_support';
    }

    /* Showing the support listing */
    public function index() {
        $where = [];
        if(auth()->user()->user_role == UserRole::CLIENT) {
            $where = ['client_id' => auth()->id()];
        }
        $this->data['supports'] = Support::withoutTrashed()->where($where)->latest()->get();
        return view('admin.support.index', $this->data);
    }

    /* Showing support create form */
    public function create() {
        $this->data['clients'] = User::withoutTrashed()->where('user_role', UserRole::CLIENT)->get();
        $this->data['loans'] = Loan::withoutTrashed()->get();
        return view('admin.support.create', $this->data);
    }

    /* Storing the support ticket */
    public function store(Request $request) {
        try {
            $rules = [
                'client_id'     => 'required|integer|'. Rule::exists('users', 'id')->where('user_role', UserRole::CLIENT)->where('active_status', Status::ENABLE),
                'loan_id'       => 'required|integer|'. Rule::exists('loans', 'id')->where('client_id', $request->client_id)->where('deleted_at', NULL),
                'issue_details' => 'required'
            ];
            $messages = [
                'client_id.required'     => 'Please select client!',
                'client_id.exists'       => 'Please select valid client!',
                'loan_id.required'       => 'Please select loan!',
                'loan_id.exists'         => 'Please select valid loan!',
                'issue_details.required' => 'Please enter the issue details!'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $insertArr = [];
            $alphanumeric = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; // To generate unique ticket no
            $insertArr['ticket_no'] = substr(str_shuffle($alphanumeric), 0, 10);
            $insertArr['client_id'] = $request->client_id;
            $insertArr['created_by'] = $request->created_by;
            $insertArr['loan_id'] = $request->loan_id;
            $insertArr['issue_details'] = $request->issue_details;
            $ticket = Support::create($insertArr);

            if(auth()->user()->user_role == UserRole::SUPERADMIN) {
                $route = '';
                $mailData = [
                    'type'       => 'ticketGenerated',
                    'ticketNo'   => $ticket->ticket_no,
                    'createdFor' => $ticket->client->name,
                    'createdBy'  => $ticket->user->name,
                    'loan'       => $ticket->loan->loan_label,
                    'issue'      => $ticket->issue_details
                ];
                Mail::to($ticket->client->email)->send(new MailSupport($mailData));
            } else {
                $route = 'customer.';
                $mailData = [
                    'type'       => 'ticketGenerated',
                    'ticketNo'   => $ticket->ticket_no,
                    'createdFor' => $ticket->user->name,
                    'createdBy'  => $ticket->client->name,
                    'loan'       => $ticket->loan->loan_label,
                    'issue'      => $ticket->issue_details
                ];
                Mail::to(auth()->user()->email)->send(new MailSupport($mailData));
            }
            return redirect()->route($route.'support')->with('success', 'Ticket generated successfully!');
        } catch (Exception $e) {
            return back()->with('danger', 'Something went wrong. Please try again!');
        }
    }

    /* Closing the ticket */
    public function closeTicket(string $id) {
        $ticket = Support::find($id);
        $ticket->status = Status::CLOSED;
        $ticket->save();

        $mailData = [
            'type'       => 'ticketClosed',
            'ticketNo'   => $ticket->ticket_no,
            'createdFor' => $ticket->client->name,
            'createdBy'  => $ticket->user->name
        ];
        Mail::to($ticket->client->email)->send(new MailSupport($mailData));

        return redirect()->route('support')->with('success', 'Ticket closed successfully!');
    }

    /* Chat page */
    public function chat(string $id) {
        $this->data['id'] = $id;
        $this->data['support'] = Support::find($id);
        $this->data['chats'] = Chat::withoutTrashed()->where('support_id', $id)->get();
        return view('admin.support.chat', $this->data);
    }

    /* Storing the chats */
    public function chatStore(Request $request, string $id) {
        try {
            $rules = [
                'message' => 'required'
            ];
            $messages = [
                'message.required' => 'Please enter the message!'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $insertArr = [];
            $insertArr['support_id'] = $id;
            $insertArr['message_from'] = $request->message_from;
            $insertArr['message_to'] = $request->message_to;
            $insertArr['message'] = $request->message;
            $message = Chat::create($insertArr);

            $support = Support::find($id);
            $mailData = [
                'type'     => 'chat',
                'ticketNo' => $support->ticket_no,
                'userTo'   => $message->userTo->name,
                'userFrom' => $message->userFrom->name,
                'message'  => $message->message
            ];
            Mail::to($message->userTo->email)->send(new MailSupport($mailData));

            return redirect()->back();
        } catch (Exception $e) {
            return back()->with('danger', 'Something went wrong. Please try again!');
        }
    }
}
