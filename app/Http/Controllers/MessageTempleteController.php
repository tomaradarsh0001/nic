<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Str;



class MessageTempleteController extends Controller
{
    /*public function show()
    {
        $templates = Template::select('id', 'action', 'type', 'subject', 'template', 'status')->paginate(10);
        return view('communication.index', compact('templates'));
    }*/


    public function show()
    {
        return view('communication.indexDatatable');
    }

    public function getMessageTemplateListing(Request $request)
    {
        $query = Template::query()->select('templates.*');
    
        // Only include columns that actually exist in the database
        $columns = ['action', 'type', 'subject', 'template', 'status']; // Remove 'variables' and 'userAction'
        $totalData = $query->count();
        $totalFiltered = $totalData;
    
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column', 0); // Get the index of the column to order by
        $order = $columns[$orderColumnIndex] ?? $columns[0]; // Default to the first column if the index is invalid
        $dir = $request->input('order.0.dir', 'asc'); // Default to ascending if not provided
    
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search) {
                $q->where('templates.action', 'LIKE', "%{$search}%")
                  ->orWhere('templates.type', 'LIKE', "%{$search}%")
                  ->orWhere('templates.subject', 'LIKE', "%{$search}%")
                  ->orWhere('templates.template', 'LIKE', "%{$search}%")
                  ->orWhere('templates.status', 'LIKE', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }
    
        $templates = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();
    
        $data = [];
        foreach ($templates as $index => $template) {
            $variables = [];
            preg_match_all('/\@\[([^\]]*)\]/', $template->template, $matches);
            // preg_match_all('/\{([^}]*)\}/', $template->template, $matches);
            // preg_match_all('/\{\(([^)]*)\)\}/', $template->template, $matches);
            foreach ($matches[1] as $placeholder) {
                $variables[] = '<span class="badge rounded-pill text-dark bg-light-success p-1 text-uppercase px-2 mx-1">' . htmlspecialchars($placeholder, ENT_QUOTES, 'UTF-8') . '</span>';
            }
    
            $data[] = [
                'id' => $start + $index + 1, // Auto-incrementing ID
                'action' => htmlspecialchars($template->action, ENT_QUOTES, 'UTF-8'),
                'type' => htmlspecialchars($template->type, ENT_QUOTES, 'UTF-8'),
                'subject' => htmlspecialchars($template->subject, ENT_QUOTES, 'UTF-8'),
                'template' => Str::limit(htmlspecialchars($template->template, ENT_QUOTES, 'UTF-8'), 50),
                'variables' => implode(' ', $variables), // Computed, not part of the database
                'status' => $template->status == 1
                    ? '<a href="' . route("template.status", $template->id) . '">
                        <div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                            <i class="bx bxs-circle me-1"></i>Active
                        </div></a>'
                    : '<a href="' . route("template.status", $template->id) . '">
                        <div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                            <i class="bx bxs-circle me-1"></i>In-Active
                        </div></a>',
                'userAction' => '<a href="' . route("template.use", $template->id) . '" class="btn btn-primary px-5">Edit</a>', // Computed, not part of the database
            ];
        }
    
        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ]);
    }
    



    public function create()
    {
        return view('communication.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|in:sms,whatsapp,email',
            'action' => 'required|string|max:255',
            'template' => 'required|string',
        ]);
        if ($validatedData) {
            $template = Template::create([
                'type' => $request->type,
                'action' => $request->action,
                'subject' => $request->subject,
                'template' => $request->template,
                'status' => 0,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id()
            ]);
            if ($template) {
                return redirect()->back()->with('success', 'Template added successfully!');
            } else {
                return redirect()->back()->with('false', 'Template not added!');
            }
        }
    }


    public function useTemplate($id)
    {
        $template = Template::findOrFail($id);
        return view('communication.use', compact('template'))->with('success', 'Template selected successfully!');
    }
    public function showTemplate($id)
    {
        $template = Template::where('id', $id)->value('template');
        preg_match_all('/\{([^}]*)\}/', $template, $matches);
        $placeholders = $matches[1];
        return view('communication.index', compact('template', 'placeholders'));
    }

    public function update(Request $request, $id)
    {
        $template = Template::findOrFail($id);
        $template->update([
            'action' => $request->input('action'),
            'subject' => $request->input('subject'),
            'template' => $request->input('template'),
        ]);

        return redirect()->route('msgtempletes')->with('success', 'Template updated successfully.');
    }

    public function updateStatus($id)
    {
        $template = Template::findOrFail($id);
        $type = $template->type;
        $action = $template->action;
        if ($template->status == 0) {

            $templates = Template::where('type', $type)->where('action', $action)->where('id', '!=', $id)->get();
            foreach ($templates as $data) {
                $data->status = 0;
                $data->save();
            }
            $template->status = 1;
            if ($template->save()) {
                return redirect()->back()->with('success', 'Template status updated successfully.');
            } else {
                return redirect()->back()->with('failure', 'Template status not updated.');
            }
        } else {
            return redirect()->back()->with('failure', "Template status can't be updated.");
        }
    }
}
