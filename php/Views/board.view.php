<div class="board">
    <table>
     <tr>
       <?php if (!$winner ):
        for ($i=1;$i<= $board::COLUMNS ;$i++): ?>
         <td><input type='submit' name='columna' value='<?=$i ?>' /></td>
      <?php endfor ; else: ?>
        <h1>El guanyador es el jugador <?=  $winner ->getName() ?></h1>
      <?php endif ?>
     </tr>
      <?php for ($j=1;$j<= $board::FILES ;$j++):  ?>
          <tr>
         <?php for ($k=1;$k<= $board::COLUMNS ;$k++):  ?>
             <?php echo match ($board->getSlots()[$j][$k]){
                0 => '<td class="buid"></td>',
                1 => '<td class="player1"></td>',
                2 => '<td class="player2"></td>'};
                endfor ;
            endfor   ?>
         </tr>
    </table>
</div>