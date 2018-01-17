<?php
include ('connect.php');

$projectId       = filter_input(INPUT_POST, 'projectId', FILTER_SANITIZE_NUMBER_INT);
$projectCategory = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$projectTitle    = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$projectSummary  = filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$projectContent  = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$projectImgPath  = filter_input(INPUT_POST, 'imgPath', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//echo nl2br($projectId . "\n");
//echo nl2br($projectCategory . "\n");
//echo nl2br($projectTitle . "\n");
//echo nl2br($projectSummary . "\n");
//echo nl2br($projectContent . "\n");
//echo nl2br($projectImgPath . "\n");


//creating query to insert rows in the database table
//$query = "INSERT INTO projects (category , title , summary , content , imgPath )
//          VALUES               (:category, :title, :summary, :content, :imgPath)";
////using $db from connect.php and calling prepare function to load the query
//$statement = $db->prepare($query);
////binding value :tweet with $tweet
//$statement->bindValue(':category', $projectCategory);
//$statement->bindValue(':title', $projectTitle);
//$statement->bindValue(':summary', $projectSummary);
//$statement->bindValue(':content', $projectContent);
//$statement->bindValue(':imgPath', $projectImgPath);
////Execute the INSERT.
//$statement->execute();
////Determine the primary key of the inserted row.
//$insert_id = $db->lastInsertId();




// Build the parameterized SQL query and bind to the above sanitized values.
$query = "UPDATE projects
                      SET category = :category,
                          title = :title,
                          summary = :summary,
                          content = :content,
                          imgPath = :imgPath
                      WHERE projectId = :projectId";
$statement = $db->prepare($query);
$statement->bindValue(':category', $projectCategory);
$statement->bindValue(':title', $projectTitle);
$statement->bindValue(':summary', $projectSummary);
$statement->bindValue(':content', $projectContent);
$statement->bindValue(':imgPath', $projectImgPath);
$statement->bindValue(':projectId', $projectId, PDO::PARAM_INT);

// Execute the UPDATE.
$statement->execute();

//debugging
echo $statement -> errorCode();
?>

<form action="" method="post" class="form-horizontal">
    <fieldset>
        <input id="projectTitle"   name="projectId"   type="text" class="form-control" placeholder="ID" required>
        <input id="projectTitle"   name="title"   type="text" class="form-control" placeholder="Project Title" required>
        <input id="projectSummary" name="summary" type="text" class="form-control" placeholder="Summary" required>
        <input id="projectSummary" name="category" type="text" class="form-control" placeholder="category" required>
        <input id="projectSummary" name="imgPath" type="text" class="form-control" placeholder="imgPath" required>
        <textarea id="WYSIWYG" class="ckeditor" name="content" placeholder="Content" required></textarea>


        <!-- buttons -->
        <div class="form-group">
            <div class="col-xs-12">
                <button name="newProject" type="submit" class="btn btn-primary">Add Project</button>
                <button name="cancelNewProject" type="submit" class="btn btn-default">Cancel</button>
            </div>
        </div>
    </fieldset>
</form>
