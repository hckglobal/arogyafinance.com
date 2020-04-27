<?php

namespace App\Http\Controllers\Admin\Question;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Question;
use App\Parameter;
use App\Level;
use App\Option;

class QuestionController extends Controller
{
    /**
     * Display all the questions.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Manage Questions";
        $questions = Question::all();        
        return view('admin.pages.question.index')->with(['questions'=>$questions,'title'=>$title]); 
    }

    /**
     * Show the form for creating a new question.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Add New";
        $parameters = Parameter::all();
      	$levels = Level::all();
      	$options = Option::all();        
        return view('admin.pages.question.create')->with(['title'=>$title,'parameters'=>$parameters,
                                                      'levels'=>$levels,'options'=>$options]);
    }

    /**
     * Store a newly created question into database.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = Question::create(["text_en"=>$request->get('text_en'),
                                    "text_hi"=>$request->get('text_hi'),
                                    "text_mr"=>$request->get('text_mr'),
                                    "text_gu"=>$request->get('text_gu'),
                                    "text_bn"=>$request->get('text_bn'),
                                    "parameter_id"=>$request->get('parameter'),
                                    "level_id"=>$request->get('level')]);
        $option_text = $request->get('option_name');
        $option_value = $request->get('option_value');
        $arrlength = count($option_text);

        for ($i=0; $i<$arrlength ; $i++) {
            $option = new Option();
            $option->question_id=$question->id;
            $option->text= $option_text[$i];
            $option->value= $option_value[$i];
            $option->save();
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified question.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = "Edit Question";
        $question= Question::find($id);
        $parameters = Parameter::all();
        $levels = Level::all();
        return view('admin.pages.question.edit')->with(['title'=>$title,'question'=>$question,
                                                    'parameters'=>$parameters,'levels'=>$levels]);
    }

    /**
     * Update the specified question in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question =  Question::find($id);
        $question->update($request->all());
        $option_text = $request->get('option_name');
        $option_value = $request->get('option_value');	
        Session::flash('info','Question updated');
        //delete all the present options
        foreach ($question->options as $option) {
           $option->delete();
        }    
        //add the new options
        $arrlength = count($option_text);

         for ($i=0; $i<$arrlength ; $i++) {
            $option = new Option();
            $option->question_id=$question->id;
            $option->text= $option_text[$i];
            $option->value= $option_value[$i];
            $option->save();
        }
        return redirect()->back();
    }

    /**
     * Remove the specified question from database.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Question::destroy($id);
        Session::flash('info','Question deleted');    
        return redirect()->back();
    }
}
