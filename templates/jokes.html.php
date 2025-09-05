<!doctype html>
<html>
    
    <p><?=$totaljokes?> jokes have been submitted to the Internet
Joke Database.</p>

    <?php foreach($jokes as $joke): ?>
        <blockquote>
            <p> <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'utf-8')?> 
             (ON <?php 
                    $date=new DateTime($joke['jokedate']);
                    echo  $date->format('jS F Y');
             ?>)

                <a href="editjoke.php?id=<?=$joke['id']?>">Edit</a>
                
                <form action="deletejoke.php" method="post">
                    <input type="hidden" name="id" value="<?=$joke['id'];?>">
                    <input type="submit" value="Delete">
                </form>
            </p>
        </blockquote>
    <?php endforeach; ?>
  

</html>