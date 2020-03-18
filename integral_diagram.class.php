<?php
///////////////////////////////////////////////////////////////////////////////////////////
/////////// Author    : Reza Salehi
///////////	Contact   : zaalion@yahoo.com
/////////// Copyright : free for non-commercial use . 
///////////////////////////////////////////////////////////////////////////////////////////

	class integral_diagram
		{
				
		function integral_diagram($dimx, $dimy, $x_start, $x_end, $br, $bg, $bb, $ar, $ag, $ab, $function_x, $step, $hasgrid)
			{
			$this->sum=0;
			$this->dimx=(int)$dimx;
			$this->dimy=(int)$dimy;
			$this->x_start=(int)$x_start;
			$this->x_end=(int)$x_end;
			$this->br=(int)$br;
			$this->bg=(int)$bg;
			$this->bb=(int)$bb;
			$this->ar=(int)$ar;
			$this->ag=(int)$ag;
			$this->ab=(int)$ab;
			$this->function_x=$function_x;
			$this->step=(real)$step;
			$this->hasgrid=$hasgrid;
			}
			
		//---- some validations.
		function doler()
			{
			$this->function_x=str_replace('x','$x',$this->function_x);
			}
		function validate()
			{
			if(substr_count($this->function_x,'(')!=substr_count($this->function_x,')'))
				{
				header("Location: index.html");
				die();
				}
			}
		function yscale()
			{
			if((substr_count($this->function_x,'sin')>0)||(substr_count($this->function_x,'cos')>0))
				return(100);
			else
				return(1);
			}
		//----function to calculate integral.
		function calculate()
			{
			for($x=$this->x_start; $x<$this->x_end; $x+=$this->step)
				{
				eval('$first='.$this->function_x.';');
				$x+=$this->step;
				eval('$second='.$this->function_x.';');
				$x-=$this->step;
				$this->sum+=(((real)$second+(real)$first)*(real)$this->step/2);
				}
			}
		//----main function.
		function draw()
			{
			header("Content-type: image/jpeg");
			$image=imagecreate($this->dimx,$this->dimy);
			$col=imagecolorallocate($image,$this->br,$this->bg,$this->bb);
			$col1=imagecolorallocate($image,$this->ar,$this->ag,$this->ab);
			$grcol=imagecolorallocate($image,8,100,8);
			$this->validate();
			$this->doler();
			$this->calculate();
			if($this->hasgrid=='1')
				{
				//---- vertical grids.
				for($i=0;$i<$this->dimx;$i+=10)
					imageline($image,$i,0,$i,$this->dimy,$grcol);
				//---- horizontal grids.
				for($i=0;$i<$this->dimy;$i+=10)
					imageline($image,0,$i,$this->dimx,$i,$grcol);
				}
			imageline($image, $this->dimx/2, 0, $this->dimx/2, $this->dimy, $col1);
			imageline($image, 0, $this->dimy/2, $this->dimx, $this->dimy/2, $col1);
			//----
			$j=0;
				for($x=-$this->dimx/2; $x<$this->dimx/2; $x+=$this->step)
				{
					if(($x>$this->x_start && $x<$this->x_end) && $x%2==0)
					{
						imageline($image, $this->x_points[$j]+$this->dimx/2, ($this->y_points[$j]*(-1))+$this->dimy/2, $this->x_points[$j]+$this->dimx/2, $this->dimy/2-1, $grcol);
					}
					eval('$this->x_points[$j]= $x ;');
					eval('$this->y_points[$j]='.$this->yscale().'*'.$this->function_x.';');
					imagesetpixel($image,$this->x_points[$j]+$this->dimx/2,($this->y_points[$j]*(-1))+$this->dimy/2 , $col1);			
					//----
					//----
				}
			imagestring ($image, 2, 40, $this->dimy-35, $this->x_start, $col1);
			imagestring ($image, 2, 20, $this->dimy-25, "sum(".str_replace('$x','x',$this->function_x).')= '.$this->sum, $col1);
			imagestring ($image, 2, 40, $this->dimy-15, $this->x_end, $col1);
			imagejpeg($image,"integral.jpg",100);
			}	
		}				
?>